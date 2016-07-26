/*
 * Host Dispatcher Shell Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>
 * All rights reserved.
 * 
 */
#include <stdio.h>
#include <stdlib.h>
#include "utility.h"
#include <stdbool.h>

// Define your utility functions here, you will likely need to add more...
// Checks if there are enough resources for the memory
bool checkresources (resources *res, int scanner, int printer, int modem, int cd_drive )
{
	if(res->scanners < scanner)
	{
		return false;
	}
	if(res->printers < printer)
	{
		return false;
	}
	if(res->modems < modem)
	{
		return false;
	}
	if(res->cd_drives < cd_drive)
	{
		return false;
	}
	return true;

}
//checks is there is enough memory for the resource
bool check_mem(resources *res, int size)
{
	int total = 0;
	// Loops through the memory 
	for(int i =0; i < 1024-64; i++)
	{	
		// checks if memory is 0
		if(res->memory[i] != 1)
		{
			// increment counter to see if it matches size
			total++;
		}
		else
		{
			// resets counter to 0 if one is reached
			total = 0;
		}
		// checks if the size is equal to the count
		if(total == size)
		{
			return true;
		}
	}
	return false;
}
// allocates memory
int allocate_mem(resources *res, int size)
{
	int check = 1;
	int startingAddress = 0;
	int count = 0;
	// loops through all the poosible memory location
	for(int i = 0; i < 1024-64; i++)
	{
		//checks if memory is 0
		if(res->memory[i] != 1)
		{
			// checks if memory starts its count again
			if(check == 1)
			{
				// reallocate starting address
				startingAddress = i;
				check = 2;
			}
			// increments counte
			count++;
			// if the size is the same as count
			if(count == size)
			{
				// sets the memory locations to 1
				for(int i = 0; i < size; i++)
				{
					res->memory[startingAddress + i] = 1;
				}
				// returns the starting address
				return startingAddress;
			}
		}else
		{	// resets checks wehn 1 is encoutnered
			count = 0;
			check = 1;
		}
	}
	// returns if no memory is allocated
	return 1999;
}
// Sets all of the memory to 0
void clear_mem(resources *res)
{

	for(int i = 0; i < 1024; i++)
	{
		res->memory[i] = 0;
	}
	
}
// sets all the memory from a specific location for a certain amount of size to 0
void free_mem(resources *res, int start, int size )
{
	for(int i = 0; i < size; i++)
	{
		res->memory[i+start] = 0;
	}	

}
// allocates resources
void alloc_res (resources *res, int scanner, int printer, int modem, int cd_drive )
{
	res->scanners = res->scanners - scanner;
	res->printers = res->printers - printer;
	res->modems = res->modems - modem;
	res->cd_drives = res->cd_drives - cd_drive;
}
// deallocates resources
void free_res(resources *res, int scanner, int printer, int modem, int cd_drive )
{
	res->scanners = res->scanners + scanner;
	res->printers = res->printers + printer;
	res->modems = res->modems + modem;
	res->cd_drives = res->cd_drives + cd_drive;
}
// int alloc_mem(resources res, int size)
// {
//      ...
// }

// free_mem(resources res, int index, int size)
// {
//      ...
// }

// void load_dispatch(char *dispatch_file, node_t *queue)
// {
//      ...
// }
