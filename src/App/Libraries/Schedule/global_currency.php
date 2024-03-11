<?php

/**
 * @author: Morten Haugstad
 * @description: This script is responsible for updating the global currency every 1 minute.
 * 				 In essence this script gives each player a set amount of money every minute based on their score
 *
 */

/**
 * Theory:
 * 		- In the users table we get the user id
 *		- In the wallet table we have a user_id attached to the current amount of money they have
 */


$ISK_Multiplier = 0.0;

function getUsers() {
	// Get all the users in the database, their ID's
}

function updateUser($UserID, $)