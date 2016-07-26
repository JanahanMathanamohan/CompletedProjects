/*
 * Tutorial 4 Jeopardy Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>
 * All rights reserved.
 *
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "players.h"

// Returns true if the player name matches one of the existing players
bool player_exists(player *players, char *name)
{
	// Goes through all the players
	for(int i = 0; i < 4; i++)
	{
		// Checks if they are a valid name
		if(strcmp(name, players[i].name)==0)
		{
			return true;
		}
	}
	return false;
}

// Go through the list of players and update the score for the 
// player given their name
void update_score(player *players, char *name, int score)
{
	// Goes through the player
    for(int i = 0; i < 4; i++)
	{
		//  Compare the nmae and if it exists add the score value
		if(strcmp(name, players[i].name)==0)
		{
			players[i].score += score;
		}
	}
}