/*
 * MyShell Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>//
 * All rights reserved.
 * 
 */
#ifndef UTILITY_H_
#define UTILITY_H_
#include <stdbool.h>
static char *CLEAR_SCREE_ANSI = "\e[1;1H\e[2J";
// Include your relevant functions declarations here they must start with the 
// extern keyword such as in the following example:
// extern void display_help(void);
// Checks a folder to see if the file pass through is located in it
 	extern bool foldercheck(char *filename);
// Prints out the files in a folder 
 	extern void directory(void);
// Changes the directory if it exists
 	extern void changedir (char *dir);
// Clears the shell of all charcters
 	extern void clear(void);
// Prints out whatever was typed in
	extern void echo(char s [][256], int num_entries);
// Pauses the screen till enter is pressed
	extern void pausing(void);
// Prints out the enviroment
	extern void environ(void);
#endif /* UTILITY_H_ */
