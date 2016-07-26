/*
 * Host Dispatcher Shell Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>
 * All rights reserved.
 * 
 */
#ifndef QUEUE_H_
#define QUEUE_H_
#include <stdbool.h>
#include "utility.h"

// Your linked list structure for your queue
// typedef ... 
//  ...
//  proc process;
//  ...
//} node_t; 
// Struct for queue
typedef struct queue
{
	proc process;
	struct queue * next;

} node_t;

// Include your relevant FIFO queue functions declarations here they must start 
// with the extern keyword such as in the following examples:

// Add a new process to the queue, returns the address of the next node added
// to the linked list

extern void push(node_t *head, proc process);

extern proc pop(node_t ** tail);

extern bool isEmpty(node_t *head);


#endif /* QUEUE_H_ */