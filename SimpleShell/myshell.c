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
#include "myshell.h"

// Put macros or constants here using #define
#define BUFFER_LEN 256
#define NUM_WORDS 80
#define LENGTH_WORD 20


// Put global environment variables here

 char tokens[20][256];
 int i =0;
 char enter = 0;
 char holder[256];
// Define functions declared in myshell.h here
 void tokenize(char *input)
 {
    // fills with empty strings

    //String tokenizer for space
    char *token = strtok(input, "\n ");
    i = 0;
    //Loops it 
    while(token != NULL)
    {
        strcpy(tokens[i],token);        
        token = strtok(NULL,"\n");
        i++;

    }

}
void clearTokens(void)
{
    for(int k =0; k < 20; k++)
    {
        strcpy(tokens[k], "");

    }
}

int main(int argc, char *argv[])
{
    // Input buffer and and commands
    char buffer[BUFFER_LEN] = { 0 };
    char command[BUFFER_LEN] = { 0 };
    char arg[BUFFER_LEN] = { 0 };
    char fileN [256] = {0};
    bool enterManual = true;
    // variable used to check pass
    bool check =false;

    // Get the argurment for the file.
    tokenize(argv[1]);
    // Checking through the files for the bat file
    check = foldercheck(tokens[0]);
    // copies the file into a tmp variable before we clear tokens
    strcpy(fileN, tokens[0]);
    clearTokens();
    // If the file was found
    if(check)
    {   
        // Load the file
        FILE *f;
        f=fopen(fileN, "r");

        //sets it so you do not go into manual entry afterwords
        enterManual = false;

        // Enters a loop to get the inputs from the file
        while(fgets(buffer, BUFFER_LEN,f) != NULL)
        {
            // tokenizes the buffer
            tokenize(buffer);
            strcpy(command, tokens[0]);
            //Checks for commands
            if(strcmp(command, "dir") ==0)
            {
                directory();
            }
            else if (strcmp(command, "cd") == 0)
            {

                changedir(tokens[1]);
            }

            else if(strcmp(command, "clr") ==0)
            {
                clear();
            }
            else if(strcmp(command, "echo") == 0)
            {
                echo(tokens,i);
            }

            else if(strcmp(command, "pause") == 0)
            {
                pausing();
            }

            else if(strcmp(command, "environ")==0)
            {
                environ();
            }
            else if(strcmp(command, "help") ==0)
            {
                //Opens the read me file
                FILE *fp;
                fp=fopen("README", "r");
                // checking if it is a valid command in the ReadMe
                check = true;
                for(int s = 0;fgets(holder,60,fp) != NULL; s++)
                {
                    // checks all even lines since every even line in read me has the command
                    if((s%2) == 0)
                    {
                        tokenize(holder);
                        if(strcmp(holder, tokens[1]) ==0)
                        {
                            // gets the next line which is the line with the instruction on how to use it
                            printf("%s",fgets(holder,60,fp));
                            check = false;
                            break;
                        }
                    }
                }
                // THe command does not exist if not found
                if(check)
                {
                    printf("Does not exist");
                }
            }
            // quit command -- exit the shell
            else if (strcmp(command, "quit") == 0)
            {
                return EXIT_SUCCESS;
            }
            // If it is not a valid command checks if they are trying to start a program
            else
            {   
                // Check if there is a file in the program
                check = false;
                check = foldercheck(command);
                // if is found fork and run the program
                if(check)
                {
                    // add ./ to the file name to run
                    char begin[256] = {"./"};
                    strcat(begin, command);
                    // fork
                    pid_t parent = getpid();
                    pid_t pid = fork();
                    // if it is the child node runs
                    if(pid >= 0)
                    {
                        system(begin);
                    }
                }
                // Command does not exist
                else
                {
                    printf("Unsupported command, use help to display the manual. Please enter Manualy. %s \n",  command);
                    clearTokens();
                    enterManual = true;
                    break;
                    
                }
            }
            clearTokens();
        }
    }
    if(enterManual)
    {

        while (fgets(buffer, BUFFER_LEN, stdin) != NULL)
        {
            // tokenizes the buffer
            tokenize(buffer);
            strcpy(command, tokens[0]);
            //Checks for commands
            if(strcmp(command, "dir") ==0)
            {
                directory();
            }
            else if (strcmp(command, "cd") == 0)
            {

                changedir(tokens[1]);
            }

            else if(strcmp(command, "clr") ==0)
            {
                clear();
            }
            else if(strcmp(command, "echo") == 0)
            {
                echo(tokens,i);
            }

            else if(strcmp(command, "pause") == 0)
            {
                pausing();
            }

            else if(strcmp(command, "environ")==0)
            {
                environ();
            }
            else if(strcmp(command, "help") ==0)
            {
                //Opens the read me file
                FILE *fp;
                fp=fopen("README", "r");
                // checking if it is a valid command in the ReadMe
                check = true;
                for(int s = 0;fgets(holder,60,fp) != NULL; s++)
                {
                    // checks all even lines since every even line in read me has the command
                    if((s%2) == 0)
                    {
                        tokenize(holder);
                        if(strcmp(holder, tokens[1]) ==0)
                        {
                            // gets the next line which is the line with the instruction on how to use it
                            printf("%s",fgets(holder,60,fp));
                            check = false;
                            break;
                        }
                    }
                }
                // THe command does not exist if not found
                if(check)
                {
                    printf("Does not exist");
                }
            }
            // quit command -- exit the shell
            else if (strcmp(command, "quit") == 0)
            {
                return EXIT_SUCCESS;
            }
            // If it is not a valid command checks if they are trying to start a program
            else
            {   
                // Check if there is a file in the program
                check = false;
                check = foldercheck(command);
                // if is found fork and run the program
                if(check)
                {
                    // add ./ to the file name to run
                    char begin[256] = {"./"};
                    strcat(begin, command);
                    // fork
                    pid_t parent = getpid();
                    pid_t pid = fork();
                    // if it is the child node runs
                    if(pid >= 0)
                    {
                        system(begin);
                    }
                }
                // Command does not exist
                else
                {
                    printf("Unsupported command, use help to display the manual.%s \n",  command);
                    
                }
            }
            clearTokens();
        }    
    }   

return EXIT_SUCCESS;
}
