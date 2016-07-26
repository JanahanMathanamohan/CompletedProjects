/*
 * Host Dispatcher Shell Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>
 * All rights reserved.
 * 
 */
#ifndef UTILITY_H_
#define UTILITY_H_

// The amount of available memory
#include <stdbool.h>
#define MEMORY 1024

// Resources structure containing integers for each resource constraint and an
// array of 1024 for the memory
// struct for resources
typedef struct resources{
	int scanners;
	int printers;
	int modems;
	int cd_drives;
	int memory [1024];
} resources;
// struct for process
typedef struct proc
{
	int arrival_time;
	int priority;
	int processor_time;
	int Mbytes;
	int printers;
	int scanners;
	int modems;
	int cds;
	int location;
	bool suspended;
	int pid;

} proc;

// Processes structure containing all of the process details parsed from the 
// input file, should also include the memory address (an index) which indicates
// where in the resources memory array its memory was allocated
// typedef struct {
//  ...
//  ...
// } process;


// Include your relevant functions declarations here they must start with the 
// extern keyword such as in the following examples:
extern void clear_mem(resources *res);
extern int allocate_mem (resources *res, int size);
extern void free_mem(resources *res, int start, int size );
extern bool checkresources (resources *res, int scanner, int printer, int modem, int cd_drives );
extern bool check_mem(resources *res, int size);
extern void alloc_res (resources *res, int scanner, int printer, int modem, int cd_drive );
extern void free_res (resources *res, int scanner, int printer, int modem, int cd_drive );
// Function to allocate a contiguous chunk of memory in your resources structure
// memory array, always make sure you leave the last 64 values (64 MB) free, should
// return the index where the memory was allocated at
// extern int alloc_mem(resources res, int size);

// Function to free the allocated contiguous chunk of memory in your resources
// structure memory array, should take the resource struct, start index, and 
// size (amount of memory allocated) as arguments
// extern free_mem(resources res, int index, int size);

// Function to parse the file and initialize each process structure and add
// it to your job dispatch list queue (linked list)
// extern void load_dispatch(char *dispatch_file, node_t *queue);


#endif /* UTILITY_H_ */