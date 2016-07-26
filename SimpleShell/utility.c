/*
 * MyShell Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>
 * All rights reserved.
 * 
 */
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <dirent.h>
#include <sys/types.h>
#include <sys/param.h> 
#include <sys/stat.h> 
#include <string.h>
#include <stdbool.h>
#include "utility.h"

// Checks a folder to see if the file pass through is located in it 
 bool foldercheck(char *filename)
 {
 	char file[256] = { 0 };
 	DIR *d;
 	char *s = getenv("PATH");
 	struct dirent *dir;
 	d = opendir(".");
 	// goes throught the directory as long as there is more files to be read
 	while((dir = readdir(d)) != NULL)
 	{
 		// compare the file name and files in the folder
 		strcpy(file,dir->d_name);
 		if(strcmp(file,filename)==0)
 		{   
 			// if found return true
 			return true;
 		}
 	}
 	// Returns false if not found
 	return false;
 }
 // Prints out the files in a folder 
 void directory(void)
 {

 	DIR *d;
 	char text [256] = { 0 };
 	char *s = getenv("PATH");
 	struct dirent *dir;
 	d = opendir(".");
 	// goes throught the directory as long as there is more files to be read
 	while((dir = readdir(d)) != NULL)
 	{
 		// prints out the files
 		strcpy(text,dir->d_name);
 		printf("%s\n",text);
 	}
 }
// Changes the directory if it exists
 void changedir (char *dir)
 {
 	char* cwd;
 	char buff[PATH_MAX + 1];
	//Checks if the directory exists
	//Also checks if you just entered cd
 	if(chdir(dir) == 0 || strcmp(dir, "")==0)
 	{
		//Sotres the directory name into cwd
 		cwd = getcwd( buff, PATH_MAX + 1 );
		//Makes sure cwd is not equal to NULL
 		if(cwd != NULL) 
 		{
 			printf( "My working directory is %s.\n", cwd );
 		}
 	}
 	else
 	{
 		printf("That directory does not exist");
 	}
 }
// Clears the shell of all charcters
 void clear (void)
 {
 	// rewrite the screen
 	write(STDOUT_FILENO,CLEAR_SCREE_ANSI,12);
 }
// Prints out whatever was typed in
 void echo (char text [][256], int num_entries)
 {
 	// prints out all the words from echo
 	for(int j =1; j <num_entries; j++)
 	{
 		printf("%s",text[j]);
 	}
 }
// Pauses the screen till enter is pressed
 void pausing(void)
 {
 	int enter;
 	//sets all echo to invisible
 	system("stty -echo");
 	// keeps in a loop as long as enter is not type
 	do
 	{
 		enter = getchar();


 	}while (enter != '\n');
 	// sets it to visible
 	system("stty echo");
 	printf("System Resume");
 }
// Prints out the enviroment
void environ()
{
 	char *s = getenv("PATH");
 	printf("%s\n", s);
} 

// Define your utility functions here, these will most likely be functions that you call
// in your myshell.c source file
