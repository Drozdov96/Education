 CREATE TABLE Versions (id SERIAL PRIMARY KEY, name VARCHAR(64));

 CREATE TABLE Players (id SERIAL PRIMARY KEY, name varchar(32));

 CREATE TABLE Fields (id SERIAL PRIMARY KEY, owner INTEGER , FOREIGN KEY (owner)
 REFERENCES Players (id));

 CREATE TABLE Games (id SERIAL PRIMARY KEY, player_one INTEGER REFERENCES Players (id),
 player_two INTEGER REFERENCES Players (id), winner INTEGER REFERENCES Players (id),
   field_one INTEGER REFERENCES Fields (id), field_two INTEGER REFERENCES Fields (id),
   end_timestamp TIMESTAMP);

 ALTER TABLE Fields ADD COLUMN  game_id INTEGER REFERENCES Games (id);

 CREATE TABLE Cells (id SERIAL PRIMARY KEY, coordinate_x INTEGER, coordinate_y INTEGER, state CHARACTER(8),
  field INTEGER REFERENCES Fields (id));