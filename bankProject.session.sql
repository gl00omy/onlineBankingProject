SELECT COLUMN_NAME
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = 'databaseTest' AND TABLE_NAME = 'MyGuests' AND COLUMN_NAME = 'id';