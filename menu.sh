#!/bin/bash

DB_NAME="2bpjs"
DB_USER="root"
DB_PASS="root"
SQL_FILE="bpjs2.sql"
APP_CONTAINER="ci_app"
DB_CONTAINER="ci_db"

show_menu() {
  echo "=========================="
  echo "  Docker CI App Manager"
  echo "=========================="
  echo "0. Pull latest Docker images"
  echo "1. Start containers"
  echo "2. Stop containers"
  echo "3. Restart containers"
  echo "4. View logs"
  echo "5. Import data"
  echo "6. Delete all tables in DB"
  echo "7. Exit"
  echo "8. Export data (dump SQL)"
}

view_logs() {
  echo "Available containers:"
  echo "1. App container ($APP_CONTAINER)"
  echo "2. DB container ($DB_CONTAINER)"
  read -p "Choose container to view logs [1-2]: " container_choice

  case $container_choice in
    1)
      echo "Tailing logs for $APP_CONTAINER..."
      docker logs -f $APP_CONTAINER &
      LOG_PID=$!
      echo "Entering $APP_CONTAINER container..."
      docker exec -it $APP_CONTAINER sh
      kill $LOG_PID
      ;;
    2)
      echo "Tailing logs for $DB_CONTAINER..."
      docker logs -f $DB_CONTAINER &
      LOG_PID=$!
      echo "Entering $DB_CONTAINER container..."
      docker exec -it $DB_CONTAINER sh
      kill $LOG_PID
      ;;
    *)
      echo "❌ Invalid choice"
      ;;
  esac
}

import_data() {
  if [ ! -f "$SQL_FILE" ]; then
    echo "❌ SQL file '$SQL_FILE' not found!"
    return
  fi

  if ! docker ps | grep -q "$DB_CONTAINER"; then
    echo "❌ Container '$DB_CONTAINER' is not running. Start the containers first."
    return
  fi

  echo "📥 Importing data from $SQL_FILE into $DB_NAME..."
  docker exec -i $DB_CONTAINER mysql -u$DB_USER -p$DB_PASS $DB_NAME < "$SQL_FILE"

  if [ $? -eq 0 ]; then
    echo "✅ Data import completed successfully."
  else
    echo "❌ Failed to import data."
  fi
}

delete_all_tables() {
  echo "⚠️  WARNING: This will delete ALL tables in the database '$DB_NAME'."
  read -p "Are you sure? This action cannot be undone! (yes/no): " confirm

  if [[ "$confirm" != "yes" ]]; then
    echo "❌ Operation cancelled."
    return
  fi

  echo "🔄 Deleting all tables in '$DB_NAME'..."

  DROP_FILE=$(mktemp)
  docker exec -i $DB_CONTAINER mysql -u$DB_USER -p$DB_PASS -Nse \
    "SELECT CONCAT('DROP TABLE IF EXISTS \`', table_name, '\`;') 
     FROM information_schema.tables 
     WHERE table_schema = '$DB_NAME';" $DB_NAME > $DROP_FILE

  sed -i '1i SET FOREIGN_KEY_CHECKS=0;' $DROP_FILE
  echo "SET FOREIGN_KEY_CHECKS=1;" >> $DROP_FILE

  docker exec -i $DB_CONTAINER mysql -u$DB_USER -p$DB_PASS $DB_NAME < $DROP_FILE

  if [ $? -eq 0 ]; then
    echo "✅ All tables deleted successfully from '$DB_NAME'."
  else
    echo "❌ Failed to delete tables."
  fi

  rm -f $DROP_FILE
}

export_data() {
  TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
  BACKUP_FILE="backup_${DB_NAME}_${TIMESTAMP}.sql"

  echo "📤 Exporting database '$DB_NAME' to '$BACKUP_FILE'..."
  docker exec $DB_CONTAINER mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > "$BACKUP_FILE"

  if [ $? -eq 0 ]; then
    echo "✅ Backup completed: $BACKUP_FILE"
  else
    echo "❌ Backup failed"
  fi
}

# Check Docker Compose is available
if ! command -v docker &> /dev/null || ! docker compose version &> /dev/null; then
  echo "❌ Docker or Docker Compose not installed or not running!"
  exit 1
fi

while true; do
  show_menu
  read -p "Enter your choice [0-8]: " choice
  case $choice in
    0)
      docker compose pull
      ;;
    1)
      docker compose up -d
      ;;
    2)
      docker compose down
      ;;
    3)
      docker compose restart
      ;;
    4)
      view_logs
      ;;
    5)
      import_data
      ;;
    6)
      delete_all_tables
      ;;
    7)
      echo "👋 Exiting..."
      break
      ;;
    8)
      export_data
      ;;
    *)
      echo "❌ Invalid option!"
      ;;
  esac
  echo ""
done
