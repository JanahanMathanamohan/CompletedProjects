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
#include <stdbool.h>
#include "questions.h"
#include "players.h"
#include "jeopardy.h"

// Put macros or constants here using #define
#define BUFFER_LEN 256

// Put global environment variables here
 char tokens[4][MAX_LEN]={" "," "," "," "}; 
// Processes the answer from the user containing what is or who is and tokenizes it to retrieve the answer.
void tokenize(char *input)
{
    // fills with empty strings
    strcpy(tokens[0]," ");
    strcpy(tokens[1]," ");
    strcpy(tokens[2]," ");
    strcpy(tokens[3]," ");
    //String tokenizer for space
    char *token = strtok(input, " ");
    int i = 0;
    //Loops it 
    while(token != NULL && i < 3)
    {
        strcpy(tokens[i],token);
        token = strtok(NULL," ");
        i++;
    }
    token = strtok(tokens[2],"\n");
}

// Displays the game results for each player, their name and final score, ranked from first to last place
void show_results(player *players)
{
    int score[4];
    for(int i = 0; i < 4; i++)
    {
        score[i] = players[i].score;
       
    }
    int tmp;
    int tmpa[4]={0,1,2,3};
    //Selection sort for the players
    for(int i = 0; i < 4; i++)
    {
        int imax = i;
        for (int j = i+1; j < 4; j++)
        {
            if(score[j] > score[imax])
            {
                imax = j;
            }
        }
        if(imax != i)
        {
            tmp = score[imax];
            score[imax] = score[i];
            score[i] = tmp;
            tmp = tmpa[imax];
            tmpa[imax] = tmpa[i];
            tmpa[i] = tmp;
        }
    }
    //Display the results
    printf("The Results are: \n");
    for(int i=0; i<4; i++)
    {
        printf("#%d: %s Score: %d \n",(i+1),players[tmpa[i]].name, players[tmpa[i]].score );
    }
}

int main(int argc, char *argv[])
{
    // An array of 4 players, may need to be a pointer if you want it set dynamically
    player players[4];
    // Random number for which player starts in jeopardy
    int playernumber = 0;
    // Variable for the status of the game
    bool gamestatus = true;
    // Tmp variable to check for input matches
    bool check = true;
    // Variable for chosen category
    char category[MAX_LEN];
    // Variable for answer
    char answer[200];
    int l =0;
    // Variable for the value chosen
    int value_chosen = 0;
    // counter to see when questions run out
    int count = 0;
    // Display the game introduction 
    printf("Welcome to jeopardy\n");
 
    // initialize each of the players in the array and get their name
    for(int i = 0; i < 4; i++)
    {
        printf("Enter Player %d name!\n",(i+1));
        scanf("%s", players[i].name);
        players[i].score = 0;
    }
    initialize_game();
    // Perform an infinite loop getting command input from users until game ends
    while (gamestatus)
    {

        // Call functions from the questions and players source files
        // Set the tmp variable
        check = true;
        // Show the categories and values and get the user choice
        display_categories();
        printf("%s pick a category and value: ", players[playernumber].name);
        scanf("%s %d",category,&value_chosen);
        do
        {
            // check if a valid category is chosen and loops till a valid one is entered
            while(check)
            {
                // go through the avalible categories and looks for a match
                for(int i = 0; i < 3; i++)
                {
                    if(strcmp(category,categories[i])==0)
                    {
                        check = false;
                    }
                }
                // if there is no match then ask for a correct category
                if(check)
                {
                    printf("Enter a valid category: ");
                    scanf("%s" , category);
                }
            }
            // set the tmp variable
            check = true;
            // check is a valid category is chosen and loops till a valid one is entered
            while(check)
            {
                // go through the avalible values and looks for a match
                for(int i = 0; i<4; i++)
                {
                    if(values[i]==value_chosen)
                    {
                        check = false;
                    }
                }
                // if there is no match then ask for a valid value
                if(check)
                {
                    printf("Enter a valid value: ");
                    scanf("%d",&value_chosen);
                }
            }
            // check if the question was already answered if it is not then asks for a new category and value and loops
            if(!already_answered(category,value_chosen))
            {
                check = false;
            }else
            {
                printf("Question was already answered pick another category and value: ");
                scanf("%s %d", category, &value_chosen);
                check = true;
            }
        }while(check);
        //DIsplays the questions
        display_question(category,value_chosen);
        l = 0;
        //Gets the answer from user
        while(fgets(answer,200,stdin) != NULL)
        {
            if(l == 0)
            {   
                l++;
            }else
            {
                break;
            }
        }
        // Tokenizes the canser
        tokenize(answer);
        //Adds the calue to players score if answer is right
        if(valid_answer(category,value_chosen,tokens[2]))
        {
            update_score(players,players[playernumber].name,value_chosen);
        }else
        {
            update_score(players,players[playernumber].name,0);
        }

        // sets it to next player
        playernumber++;
        if(playernumber>=4)
        {
            playernumber = 0;
        }
        //Increase for every turn
        count++;
        //When 12 questions have been chosen displays the results and ends the game.
        if(count>=12)
        {
            show_results(players);
            gamestatus = false;
        }

        // Execute the game until all questions are answered
        
        // Display the final results and exit
    }

    return EXIT_SUCCESS;
}
