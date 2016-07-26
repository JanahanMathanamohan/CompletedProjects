#define _XOPEN_SOURCE 700
#include <stdlib.h>
#include <stdio.h>
#include <pthread.h>
#include <semaphore.h>
#include <unistd.h>
#include <sys/wait.h>
#include <stdbool.h>

//Global Variables
pthread_mutex_t lock_x;
pthread_mutex_t lock_2;

int iGrid = 0;
int jGrid = 0;
int puzzle[9][9];
bool globalcheck = true;
int jCheck = 0;


//This function takes is the funciton that checks the rows to see if any numbers in the rows are duplicates
bool *rowValidator(void *arg)
{
	//Creates an array to store the row of numbers in 
	int tempRow[9];
	//Runs though the loop nine times (this for loop is in charge of the rows)
	for(int row = 0; row < 9; row++)
	{
		//All these counts are used to check how many of each number appears in the row
		int count1 = 0;
		int count2 = 0;
		int count3 = 0;
		int count4 = 0;
		int count5 = 0;
		int count6 = 0;
		int count7 = 0;
		int count8 = 0;
		int count9 = 0;

		//Runs though the loop nine times (this for loop is in charge of the columns)
		for(int col = 0; col< 9; col++)
		{
			//Sets an element in the array to store number from the puzzle array
			tempRow[col] = puzzle[row][col];

			if(tempRow[col]==0)
			{
				globalcheck = false;
			}

			//All this seciton of code is, is to check if the current number in the array is equal to 1 though 9
			if(tempRow[col] ==1)
			{
				//If the number is equal to the condition then increment the counter of that condition by one
				count1++;
				//This check is to determine if the same number appears twice in the row if it does then enter the if condition
				if(count1 > 1)
				{
					//Sets the global variable to false showing that the solution is not correct
					globalcheck = false;
				}
			}
						
			if(tempRow[col] ==2)
			{
				
				count2++;
				if(count2 > 1)
				{
					globalcheck = false;
				}
			}
			if(tempRow[col] ==3)
			{
				
				count3++;
				if(count3 > 1)
				{
					globalcheck = false;
				}
			}
			
			if(tempRow[col] ==4)
			{
				
				count4++;
				if(count4 > 1)
				{
					globalcheck = false;
				}
			}
			
			if(tempRow[col] ==5)
			{
				
				count5++;
				if(count5 > 1)
				{
					globalcheck = false;
				}
			}
			
			if(tempRow[col] ==6)
			{
				
				count6++;
				if(count6 > 1)
				{
					globalcheck = false;
				}
			}
			
			if(tempRow[col] ==7)
			{
				
				count7++;
				if(count7 > 1)
				{
					globalcheck = false;
				}
			}

			if(tempRow[col] ==8)
			{
				
				count8++;
				if(count8 > 1)
				{
					globalcheck = false;
				}
			}

			if(tempRow[col] ==9)
			{
				
				count9++;
				if(count9 > 1)
				{
					globalcheck = false;
				}
			}
		}
		//At the end of the row check if the global vairable was set false it will stop executing and return to the main method
		if(!globalcheck)
		{
			//Breaks out of the for loop
			break;
		}

	}
	return NULL;
}

//This function takes is the funciton that checks the columns to see if any numbers in the columns are duplicates
//This function is very similar to the rowValidator function which very small changes
bool *colValidator(void *arg)
{
	//Creates an array to store the row of numbers in 
	int tempCol[9];

	//Runs though the loop nine times (this for loop is in charge of the columns) 
	for(int col = 0; col < 9; col++)
 	{
 		//All these counts are used to check how many of each number appears in the row
		int count1 =0;
		int count2 =0;
		int count3 =0;
		int count4 =0;
		int count5 =0;
		int count6 =0;
		int count7 =0;
		int count8 =0;
		int count9 =0;

		//Rubs though the loop nine times (this for loop is in charge of the rows)
		for(int row = 0; row < 9; row++)
		{
			//Sets the temp array index to the value in the puzzle array which is some number from the sudoko board
			tempCol[row] = puzzle[row][col];
			
			//All this seciton of code is, is to check if the current number in the array is equal to 1 though 9
			if(tempCol[row] ==0)
			{
				globalcheck = false;
			}
			if(tempCol[row] ==1)
			{
				count1++;
				if(count1 > 1)
				{
					globalcheck = false;
				}
			}
						
			else if(tempCol[row] ==2)
			{
				count2++;
				if(count2 > 1)
				{
					globalcheck = false;
				}
			}
			else if(tempCol[row] ==3)
			{
				count3++;
				if(count3 > 1)
				{
					globalcheck = false;
				}
			}
			
			else if(tempCol[row] ==4)
			{
				count4++;
				if(count4 > 1)
				{
					globalcheck = false;
				}
			}
			
			else if(tempCol[row] ==5)
			{
				count5++;
				if(count5 > 1)
				{
					globalcheck = false;
				}
			}
			
			else if(tempCol[row] ==6)
			{
				count6++;
				if(count6 > 1)
				{
					globalcheck = false;
				}
			}
			
			else if(tempCol[row] ==7)
			{
				count7++;
				if(count7 > 1)
				{
					globalcheck = false;
				}
			}

			else if(tempCol[row] ==8)
			{
				count8++;
				if(count8 > 1)
				{
					globalcheck = false;
				}
			}

			else if(tempCol[row] ==9)
			{
				count9++;
				if(count9 > 1)
				{
					globalcheck = false;
				}
			}

		}
		//If the global check was set to false at any point in the for loop then enter this if statement
		if(!globalcheck)
		{
			//Breaks out of the for loop
			break;
		}
	}
	return NULL;
}

//This function is used to check each three by three sqaure in the sudoko board
void *gridValidator(void *arg)
{
	//Lock the threads from entering the critical section 
	pthread_mutex_lock(&lock_2);
	//Set the limit for the for loop to 2 more then the initial statement
		int i_inc = iGrid+2;
	int j_inc = jGrid+2;
	


	//Sets a tempary array to store the numbers from the gird in
	int tempGrid[9];
	int counter = 0;
	int count1 =0;
	int count2 =0;
	int count3 =0;
	int count4 =0;
	int count5 =0;
	int count6 =0;
	int count7 =0;
	int count8 =0;
	int count9 = 0;

	//Checks again to see if a thread is still in the inner critical section
	pthread_mutex_lock(&lock_x);

	//This for loop will always run three times no matter what (i_inc is always two more then the iGrid)
	for(; iGrid <= i_inc; iGrid++)
	{	
		//This for loop will also only run for three loops no matter what (j_inc is always two more then the jGrid)
		//By doing this we are able to get a grid check (3X3)
		for(; jGrid<=j_inc; jGrid++)
		{
			//Sets the tempary array to some value in the sudoko board
			tempGrid[counter] = puzzle[iGrid][jGrid];
			
			//Checks to see if the number is either 1 though 9
			if(tempGrid[counter] ==1)
			{
				//Increments the counter by one if the value stored in the tempGrid array is 1
				count1++;
				//If there is multiple ones in the grid then enter this if statement
				if(count1 > 1)
				{
					//Sets the globalcheck to false meaning the sudoko board is incorrect
					globalcheck = false;
				}
			}

			if(tempGrid[counter] ==0)
			{

				globalcheck = false;
			}

			else if(tempGrid[counter] ==2)
			{
				
				count2++;
				if(count2 > 1)
				{
					globalcheck = false;
				}
			}
			else if(tempGrid[counter] ==3)
			{
				
				count3++;
				if(count3 > 1)
				{
					globalcheck = false;
				}
			}
			
			else if(tempGrid[counter] ==4)
			{
				
				count4++;
				if(count4 > 1)
				{
					globalcheck = false;
				}
			}
			
			else if(tempGrid[counter] ==5)
			{
				
				count5++;
				if(count5 > 1)
				{
					globalcheck = false;
				}
			}
			
			else if(tempGrid[counter] ==6)
			{
				
				count6++;
				if(count6 > 1)
				{
					globalcheck = false;
				}

			}
			
			else if(tempGrid[counter] ==7)
			{
				
				count7++;
				if(count7 > 1)
				{
					globalcheck = false;
				}
			}

			else if(tempGrid[counter] ==8)
			{
				
				count8++;
				if(count8 > 1)
				{
					globalcheck = false;
				}
			}

			else if(tempGrid[counter] ==9)
			{
				
				count9++;
				if(count9 > 1)
				{
					globalcheck = false;
				}
			}
			//We increment the counter here so we can store the number in the next index of the tempArray
			counter++;
		}
	//If a number has appeared more then once in a grid view, it will enter this section
	if(!globalcheck)
	{
		//Breaks out of the for loop
		break;
	}
	//This check it to see if you have checked the first three grids at the top if you havent you will enter this condition
	if(jCheck ==0)
	{
		//You reset the value of jGrid to 0 so you can start at the beginning for the next grid you check
		jGrid = 0;

	}
	//If you have checked the first three gird views you will want to check the next three grid views below it so you enter this condition
	if(jCheck ==1)
	{
		//Becasue you have checked the first three views, you no longer want to start checking at 0 insted you want to start checking at jGrid 3
		jGrid = 3;
	}
	//If you have checked the first 6 grid views you will want to check the last three grid views, meaning you will enter this condition
	if(jCheck ==2)
	{
		//Becasue you have checked the first 6 views, you will no longer want to start checking at the 0 index or the 3 index insted you will want to start checking from the 6 index
		//This allows you to check index 6 though index 8
		jGrid = 6;
	}

}
//This condtion is what checks to see if you have completed searching the three grids in a row
if(iGrid >= 8)
{
	//You will want to reset you iGrid so you can start checking at the start of the rows	
	iGrid = 0;
	//This is what allows the program to check the next set of grids below the ones you just checked
	jCheck++;

	//This is the initial set of jGrid for the next thread to use
	if(jCheck ==1)
		{
			jGrid = 3;
			//Sets the limit of the for loop to two more then the initial value
			j_inc = jGrid + 2;
		}
	//This is the intial set of jGrid for the next thread to use
	if(jCheck ==2)
		{
			jGrid =6;
			//Sets the limit of the for loop to two more then the initial value
			j_inc = jGrid+2;
		}
}
	//Unlocks both of the locks for the next thread to use
	pthread_mutex_unlock(&lock_x);
	pthread_mutex_unlock(&lock_2);
	pthread_exit(NULL);
	
}

void validate(int sudoku [][9])
{
	//Initalizes the two locks
	pthread_mutex_init(&lock_x, NULL);
	pthread_mutex_init(&lock_2, NULL);



	//Reads all the values in the board and stores them into an array called puzzle 
	//Makes accessing the numbers in the sudoko board easier then have to keep on reading from a text file
 	for(int i = 0; i < 9; i++)
 	{
  		for(int j = 0; j < 9; j++)
  		{
   			puzzle[i][j] = sudoku[i][j];
  		}
 	}	

 	//Initalizes all the threads we are going to be using
 	pthread_t rowCheck;
    pthread_t colCheck;
    pthread_t gridCheck;
    pthread_t gridCheck2;
    pthread_t gridCheck3;
    pthread_t gridCheck4;
    pthread_t gridCheck5;
    pthread_t gridCheck6;
    pthread_t gridCheck7;
    pthread_t gridCheck8;
    pthread_t gridCheck9;
   

    //Creates all the threads and the function they will be working at
    pthread_create(&rowCheck, 0, rowValidator, NULL);
    pthread_create(&colCheck, 0, colValidator, NULL);
    pthread_create(&gridCheck, 0, gridValidator, NULL);
    pthread_create(&gridCheck2, 0, gridValidator, NULL);
    pthread_create(&gridCheck3, 0, gridValidator, NULL);
    pthread_create(&gridCheck4, 0, gridValidator, NULL);
    pthread_create(&gridCheck5, 0, gridValidator, NULL);
    pthread_create(&gridCheck6, 0, gridValidator, NULL);
    pthread_create(&gridCheck7, 0, gridValidator, NULL);
    pthread_create(&gridCheck8, 0, gridValidator, NULL);
    pthread_create(&gridCheck9, 0, gridValidator, NULL);



    //Waits for all the threads to finish what they are doing before we proceed in the program
    pthread_join(rowCheck, 0);
    pthread_join(colCheck, 0);
    pthread_join(gridCheck,0);
    pthread_join(gridCheck2,0);
    pthread_join(gridCheck3,0);
    pthread_join(gridCheck4,0);
    pthread_join(gridCheck5,0);
    pthread_join(gridCheck6,0);
    pthread_join(gridCheck7,0);
    pthread_join(gridCheck8,0);
    pthread_join(gridCheck9,0);

    //If the global vairable has been set to false from any of the validators it will not enter this condition and insted will execute the else statement
    if(globalcheck)
    {
    	printf("The answer is correct");
    }
    else
    {
    	printf("The answer is wrong");
    }

}