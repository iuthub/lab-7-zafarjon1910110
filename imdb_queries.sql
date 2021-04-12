/* 1 */
SELECT movies.name FROM movies WHERE year=1995

/* 2 */
SELECT COUNT(*) FROM movies
JOIN roles on movies.id=roles.movie_id
WHERE movies.name="Lost in Translation"

/* 3 */
SELECT actors.first_name, actors.last_name FROM movies
JOIN roles ON movies.id=roles.movie_id
JOIN actors ON actors.id=roles.actor_id
WHERE movies.name="Lost in Translation"

/* 4 */
SELECT directors.first_name, directors.last_name FROM movies
JOIN movies_directors ON movies.id=movies_directors.movie_id
JOIN directors ON directors.id=movies_directors.director_id
WHERE movies.name="Fight Club"

/* 5 */
SELECT COUNT(*) FROM directors
JOIN movies_directors ON movies_directors.director_id=directors.id
WHERE directors.first_name="Clint" AND directors.last_name="Eastwood";

/* 6 */
SELECT movies.name FROM directors
JOIN movies_directors ON movies_directors.director_id=directors.id
JOIN movies ON movies.id=movies_directors.movie_id
WHERE directors.first_name="Clint" AND directors.last_name="Eastwood";

/* 7 */
SELECT movies.name FROM movies
JOIN movies_genres ON movies.id=movies_genres.movie_id
WHERE movies_genres.genre="Horror"

/* 8 */
SELECT actors.first_name, actors.last_name FROM actors
JOIN roles ON actors.id=roles.actor_id
JOIN movies_directors ON roles.movie_id=movies_directors.movie_id
JOIN directors ON movies_directors.director_id=directors.id
WHERE directors.first_name="Christopher" AND directors.last_name="Nolan"