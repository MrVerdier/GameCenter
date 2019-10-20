<?php



// TRY- CATCH

// error handling for SQL statements
// if an error is made in the try section it is passed to the catch 

try {

    // INNER JOIN AND PREPARED STATEMENT

    // Inner join = joins information from two tables on a selected value, this being the foreign and primary key
    // prepared statement = prepares the query in the database and waits for the parameters to be put in. is safer and faster

    $stmt = $db->prepare('SELECT users_friends.user_one_fk, users.id, users.name, users.mail FROM users_friends
                          INNER JOIN users ON users.id = users_friends.user_one_fk
                          WHERE users_friends.user_one_fk = :userId
                          ')
    $stmt->bindValue(":userId", $iUserId);
    $stmt->execute();
}

// PDOExecption is the errors that is coming from the database. can be enabled or disabled from the connect.php
// Is great for development purposes but needs to be removed whenever publishing

catch(PDOExeption $ex){
    echo $ex;
}

// PAGINATION (LIMIT)

// SELECT * FROM users LIMIT 0,10
// Will select 10 and skip none

// SELECT * FROM users LIMIT 1,10 (OFFSET 10 can also be used)
// will skip 1 and select 10

// GROUP BY  ****************************************************

// SELECT COUNT(id), type FROM games WHERE type = 'game' ORDER BY type 

// VIEWS ****************************************************

// A virtal table based on a result-set sql query. Contains rows and columns that are taken from "real" tables
// SQL functions can be added to present data (JOIN, WHERE)

// INDEX ****************************************************

// Used for quickly finding rows in tables. Certain columns are indexed. 
// optimizes large tables 

// PRIMARY KEYS ****************************************************

// Contains a unique id. Cannot contain null values. Used for reference when using foreign keys

// foreign keys ****************************************************

// Relates to the primary key. Is constraint to it. 
// must be the same datatype as the primary key that it is linked to

// DATA TYPES ****************************************************

// Varchar = string of definable length
// Int = Integer (number) can be set to unsigned or signed (allowing negative numbers) - Tinyint, bigint, boolean
// Timestamp = date and time
// Serial = unique unsigned bigint 20
// Text = Variable width character string = 2GB of text data

// AGGREGATE (min, max, avg, count, less than, greater than, etc...) ****************************************************

// SELECT COUNT(users) FROM users = How many users are in the system
// SELECT MIN/MAX(price) FROM games = Selects the highest or the lowest price of games
// SELECT AVG(price) FROM games = Selects the average price of games
// SELECT MAX(price) FROM games WHERE price < 50 = Selects the maximum price that is less than 50 

// LIKE ****************************************************

// The LIKE operator is used in a WHERE clause to search for a specified pattern in a column.
// Used together with wildcards
// SELECT * FROM games WHERE title LIKE '%SomthingInHere%'

// ALIAS ****************************************************

// Used to rename a table or coloumn temporarily 
// only exist within the duration of the query

// AND OR ****************************************************

// When something is based on more than one condition
// WHERE this = 'this' AND this < 'this'
// WHERE this = 'this' OR this < 'this'

// ORDER BY ****************************************************

// SELECT * FROM users WHERE NAME LIKE '%A%' ORDER BY name ASC
// use it to order the data you get in either asc or desc
// can be tied together in multiple order by's

// GROUP BY ****************************************************

// The GROUP BY statement group rows that have the same values into summary rows, like "find all the users that are online and not online".
// SELECT COUNT(id), online_status FROM users GROUP BY online_status HAVING COUNT(id)

// TRUNCATE ****************************************************

// When you want to clear out a table without removing the actual table and the structure of it

// DROP ****************************************************

// Used for deleting tables and databases

// UNIQUE ****************************************************

// Used for id's and to make unique pairs so that rows cannot repeat themselves
// Both composite key and compound key describe a candidate key with more than one attribute. 

// TRANSACTIONS ****************************************************

// Used for when you want to make sure that all or none of the queries are executed. 
// is not used when it is only select statements
// ofc used for actual transactions
// I used it whenever I wanted to make sure that nothing was stored in the database without having the complete dataset (signup)

// STORED PROCEDURES ****************************************************

// Queries that are saved in the database. Can be given parameters. is faster, safer and saves space in the database
// accessed using the GUI

// HAVING ****************************************************

// Used as an extra condition in aggregated funcitons

// SELF JOIN ****************************************************

// Compare a table with itself

// SUB QUERIES / IN SELECT ****************************************************

// A subquery is a SQL query within a query.
// Subqueries are nested queries that provide data to the enclosing query.
// Subqueries can return individual values or a list of records
// Subqueries must be enclosed with parenthesis

// bindValue & bindParam ****************************************************

// The main difference is that when using bindParam(), the variable is bound as a reference and will only be evaluated at the time that execute() is called
// bindParam will take the last variable and is evaluated when the query is executed - should be used for dynamic and changing parameters
// I use bindValue because by the time the variable is in my prepared statement it is not changing

//bindValue” accept vary data types.
//Unlike the bindParam() that binds only a variable name to a parameter, with bindValue, you can bind not just a variable but also an integer, float, and string.