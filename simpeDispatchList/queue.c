/*
 * Host Dispatcher Shell Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>
 * All rights reserved.
 * 
 */
#include <stdio.h>
#include <stdlib.h>
#include "queue.h"
#include "utility.h"
#include <stdbool.h>

// Define your FIFO queue functions here, these will most likely be the
// push and pop functions that you declared in your header file

// push to the the end of the list
void push(node_t *head,  proc process)
{
	node_t * current = head;
	while(current->next != NULL){
		current = current->next;
	}
	current->next = malloc(sizeof(node_t));
	current->next->process = process;
	current->next->next = NULL;
}
// pops the first value of the queue
proc pop(node_t ** head)
{
	proc process;
	node_t * next_node = NULL;
	next_node = (*head)->next;
	process = next_node->process;
	free(*head);
	*head = next_node;
	return process;
}
// checks if the queue is emptu
bool isEmpty(node_t *head)
{
	if(head->next == NULL)
	{
		return true;
	}
	else
	{
		return false;
	}
}
