CREATE TABLE players (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  position TEXT NOT NULL,
  created_at TEXT NOT NULL
);

CREATE INDEX players_id_IDX ON players (id);
CREATE INDEX players_name_IDX ON players (name);