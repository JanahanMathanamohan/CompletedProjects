/*
 * Tutorial 4 Jeopardy Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <Janahan Mathanamohan, Stuart Calverley, Michael, Janahan>
 * All rights reserved.
 *
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "questions.h"

// Initializes the array of questions for the game
void initialize_game(void)
{
    // initialize each question struct and assign it to the questions array
	
	strcpy(questions[0].category, "programming");
	strcpy(questions[0].question, "This data type allows you to store a character?");
	strcpy(questions[0].answer, "char");
	questions[0].value = 10;
	questions[0].answered = false;
	


	strcpy(questions[1].category, "programming");
	strcpy(questions[1].question, "This data type allows you to store a list?");
	strcpy(questions[1].answer, "array");
	questions[1].value = 20;
	questions[1].answered = false;
	

	
	strcpy(questions[2].category, "programming");
	strcpy(questions[2].question, "This data type allows you to store the memory address of another variable");
	strcpy(questions[2].answer, "pointer");
	questions[2].value = 30;
	questions[2].answered = false;
	

	
	strcpy(questions[3].category, "programming");
	strcpy(questions[3].question, "This function is similar to a java object in c?");
	strcpy(questions[3].answer, "struct");
	questions[3].value = 40;
	questions[3].answered = false;
	

	
	strcpy(questions[4].category, "alogrithms");
	strcpy(questions[4].question, "This theorem has three check cases?");
	strcpy(questions[4].answer, "master");
	questions[4].value = 10;
	questions[4].answered = false;
	

	
	strcpy(questions[5].category, "alogrithms");
	strcpy(questions[5].question, "This method is used by guessing the solution and using mathematical induction?");
	strcpy(questions[5].answer, "substitution");
	questions[5].value = 20;
	questions[5].answered = false;


	strcpy(questions[6].category, "alogrithms");
	strcpy(questions[6].question, "The complexity of an algorithm is n which is also known as?");
	strcpy(questions[6].answer, "linear");
	questions[6].value = 30;
	questions[6].answered = false;

	strcpy(questions[7].category, "alogrithms");
	strcpy(questions[7].question, "This method calls itself until it is its smallest form?");
	strcpy(questions[7].answer, "recursion");
	questions[7].value = 40;
	questions[7].answered = false;

	strcpy(questions[8].category, "database");
	strcpy(questions[8].question, "Most databases run off of this software?");
	strcpy(questions[8].answer, "dbms");
	questions[8].value = 10;
	questions[8].answered = false;	

	strcpy(questions[9].category, "database");
	strcpy(questions[9].question, "This type of action allows you to send or receive information?");
	strcpy(questions[9].answer, "query");
	questions[9].value = 20;
	questions[9].answered = false;

	strcpy(questions[10].category, "database");
	strcpy(questions[10].question, "This command allows you to change the contents of the database state?");
	strcpy(questions[10].answer, "update");
	questions[10].value = 30;
	questions[10].answered = false;

	strcpy(questions[11].category, "database");
	strcpy(questions[11].question, "Every relation has subcomponents called?");
	strcpy(questions[11].answer, "attributes");
	questions[11].value = 40;
	questions[11].answered = false;
}

// Displays each of the remaining categories and question dollar values that have not been answered
void display_categories(void)
{
    // print categories and dollar values for each unanswered question in questions array
    for(int i =0; i<3; i++)
    {
    	printf("Category %d is: %s: ",(i+1),categories[i]);
    	for(int j =0; j<12; j++)
    	{
    		
    		if(!questions[j].answered && strcmp(questions[j].category, categories[i])==0)
    		{
    			printf("%d ", questions[j].value);
    		}

    	}
    	printf("\n");
    }
}

// Displays the question for the category and dollar value
void display_question(char *category, int value)
{
	for(int k =0; k <12; k++)
	{
		if(strcmp(questions[k].category, category) == 0 && questions[k].value == value)
		{
			printf("%s\n", questions[k].question);
		}
	}
}

// Returns true if the answer is correct for the question for that category and dollar value
bool valid_answer(char *category, int value, char *answer)
{
    // Look into string comparison functions
    for(int s = 0; s<12; s++)
    {
    	if(strcmp(questions[s].category, category) == 0 && questions[s].value ==value && (strcmp(questions[s].answer, answer) ==0))
    	{
    		printf("Correct! \n");
    		questions[s].answered = true;
    		return true;

    	}else if(strcmp(questions[s].category, category) == 0 && questions[s].value ==value)
    	{
    		printf("Incorrect! ");
    		printf("The answer was %s \n", questions[s].answer );
    		questions[s].answered = true;
    		return false;
    	}
    }
   return false;
}

// Returns true if the question has already been answered
bool already_answered(char *category, int value)
{
    // lookup the question and see if it's already been marked as answered
    for(int d = 0; d<12; d++)
    {
    	if(strcmp(questions[d].category, category) == 0 && value == questions[d].value && questions[d].answered)
    	{
    		return true;
    	}
    }
    return false;
}
