/*
 * Host Dispatcher Shell Project for SOFE 3950U / CSCI 3020U: Operating Systems
 *
 * Copyright (C) 2015, <GROUP MEMBERS>
 * All rights reserved.
 * 
 */
#include <stddef.h>
#include <stdlib.h>
#include <stdio.h>
#include <stdbool.h>
#include <unistd.h>
#include <signal.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <string.h>
#include "queue.h"
#include "utility.h"
#include "hostd.h"


// Put macros or constants here using #define
#define MEMORY 1024
#define BUFFER_LEN 256
char tokens[256][256];
struct resources res;
// Put global environment variables here

// Define functions declared in hostd.h here

// This is the tokenizer we use 
 void tokenize(char *input)
 {
    char *token = strtok(input, "\n, ");
    int i = 0; 
    while(token != NULL)
    {
        strcpy(tokens[i],token);        
        token = strtok(NULL,"\n, ");
        i++;
    }
}


int main(int argc, char *argv[])
{
    // ==================== YOUR CODE HERE ==================== //
    // Times is the variable to keep the time in the dispatcher
    int times = 0;
    // checks how long a process runs incase a real time process takes more than a sec
    int runtimediff = 1;
    // genreic pid variables
    pid_t pid;
    int status; 
    //Creatrion of the head of our queues
    node_t * real_time = malloc(sizeof(node_t));
    node_t * priority1 = malloc(sizeof(node_t));
    node_t * priority2 = malloc(sizeof(node_t));
    node_t * priority3 = malloc(sizeof(node_t));
    char buffer[BUFFER_LEN];
    char command[] = "./process";
    // checks to see termination cases
    bool not_empty = true;
    bool no_res = true;
    // the variable to store the file name
    char *file = argv[1];
    proc array[10];
    struct proc holder;
    FILE *f =fopen(file, "r");
    bool not_execute = true;
    // set default values of the resources
    res.scanners = 1;
    res.printers = 2;
    res.modems = 1;
    res.cd_drives = 2;
    //sets all the memory to zero
    clear_mem(&res);
    // puts all the value of the process from the text values
    for(int i =0; i<10; i++)
    {
            fgets(buffer, BUFFER_LEN, f);
            tokenize(buffer);
            array[i].arrival_time = atoi(tokens[0]);
            array[i].priority = atoi(tokens[1]);
            array[i].processor_time = atoi(tokens[2]);
            array[i].Mbytes = atoi(tokens[3]);
            array[i].printers = atoi(tokens[4]);
            array[i].scanners = atoi(tokens[5]);
            array[i].modems = atoi(tokens[6]);
            array[i].cds = atoi(tokens[7]);
            array[i].location = 1999;    
            array[i].suspended = false;
            array[i].pid = 0;
    }
    // Loops until all process are done
    while(not_empty)
    {
        // Loops the allocation of process to que until run time is 0
        while(runtimediff > 0)
        {
            //Loops through all process   
            for(int j = 0; j<10; j++)
            {
                // Checks if the arrival time is equal to the current time
                if(array[j].arrival_time == times)
                {
                    // Places process in appropriate intial que
                    if(array[j].priority == 0)
                    {
                        
                        push(real_time, array[j]);
                    }
                    else if(array[j].priority ==1)
                    {
                       
                        push(priority1, array[j]);
                    }
                    else if(array[j].priority ==2)
                    {
                        
                        push(priority2, array[j]);
                    }
                    else if(array[j].priority ==3)
                    {
                        
                        push(priority3, array[j]);
                    }
                }
            }
            // decrements run time and increases timer
            runtimediff--;
            times++;
        }
        // Checks if real time queue is not empty
        if(!(isEmpty(real_time)))
        {
            // pops the process from the queue
            printf("Process in Real Time \n");
            holder = pop(&real_time);
            // forks and executes the process
            pid = fork();
            if(pid != 0)
            {
                printf("The process arrival time: %d \nThe process priority time: %d \nThe process time: %d \n", holder.arrival_time,holder.priority,holder.processor_time );
                printf("The process size: %d \nThe process scanners printers modems cds: %d %d %d %d\n",holder.Mbytes,holder.scanners,holder.printers,holder.modems,holder.cds);
            }
            if(pid == 0)
            {
                execl(command, "");

            }
            // sets the run time diff to the process time so we know how long the process spent running
            runtimediff = holder.processor_time;
            // puts parent process to sleep for however long it is suppose to run
            sleep(holder.processor_time);
            // kills the pid
            kill(pid, SIGINT);
            waitpid(pid, &status, 0);
            // sets a flag that a process was run
            not_execute = false;

        }
        // checks if  priority1 queue is not empty and that a process was not run
        if (!(isEmpty(priority1)) && not_execute)
        {
            // pops the process
            holder = pop(&priority1);
            // checks if there are enough resources or if the process was suspended
            if((check_mem(&res,holder.Mbytes) &&  checkresources(&res,holder.scanners,holder.printers,holder.modems,holder.cds))|| holder.suspended)
            {
                // If the process was suspend
                if(holder.suspended)
                {
                    // prints out proccess unformation and send signal to continue process
                    printf("Resume Process in que1\n");
                    printf("The process arrival time: %d \nThe process priority time: %d \nThe process time: %d \n", holder.arrival_time,holder.priority,holder.processor_time );
                    printf("The process size: %d \nThe process scanners printers modems cds: %d %d %d %d\n",holder.Mbytes,holder.scanners,holder.printers,holder.modems,holder.cds);
                    printf("The process location: %d \nThe process pid: %d\n",holder.location,holder.pid);
                    kill(holder.pid, SIGCONT);
                }else
                {
                    // The process is a new procces so it allocates memory and resources
                    holder.location= allocate_mem(&res, holder.Mbytes);
                    alloc_res(&res,holder.scanners,holder.printers,holder.modems,holder.cds);
                    //forks the program
                    pid = fork();
                    if(pid != 0)
                    {
                        holder.pid = pid;
                        printf("New process in que1\n");
                        printf("The process arrival time: %d \nThe process priority time: %d \nThe process time: %d \n", holder.arrival_time,holder.priority,holder.processor_time );
                        printf("The process size: %d \nThe process scanners printers modems cds: %d %d %d %d\n",holder.Mbytes,holder.scanners,holder.printers,holder.modems,holder.cds);
                        printf("The process location: %d \nThe process pid: %d\n",holder.location,holder.pid);    
                    }else
                    {
                        execl(command, "");
                    }
                }
                // Sleeps for 1 second to let the forked program to run for a sec
                sleep(1);   
                // subtracts the processor time by 1 to get remaing processor time
                holder.processor_time = holder.processor_time-1;
                // sets the flag that program is suspended to true
                holder.suspended = true;
                // if there is still processing time is what this checks
                if(holder.processor_time > 0)
                {
                    // pushed the process to the que of priority2
                    push(priority2, holder);
                    // sends a signal to stp the process
                    kill(holder.pid, SIGTSTP);
                    // this is to just make the output more clean 
                    sleep(1);

                }else
                {
                    // if there is no process time remmaining kill the process and free the remaining resources
                    kill(holder.pid, SIGINT);
                    waitpid(holder.pid,&status,0);
                    free_mem(&res , holder.location,holder.Mbytes);
                    free_res(&res,holder.scanners,holder.printers,holder.modems,holder.cds);
                   
                }
                // sets the run time and flag of not execute
                runtimediff =1;
                not_execute = false;
            }else
            {
                // This means that there was not enough resources to start the process
                // sets the flag no resources to false
                no_res = false;
                // pushs the process back to its original queue
                push(priority1,holder);
            }
        }
       // checks if  priority2 queue is not empty and that a process was not run
        if (!(isEmpty(priority2)) && not_execute)
        {
            // pops the process
            holder = pop(&priority2);
            // checks if there are enough resources or if the process was suspended
            if((check_mem(&res,holder.Mbytes) &&  checkresources(&res,holder.scanners,holder.printers,holder.modems,holder.cds))|| holder.suspended)
            {
                // If the process was suspend
                if(holder.suspended)
                {
                    // prints out proccess unformation and send signal to continue process
                    printf("Resume Process in que2\n");
                    printf("The process arrival time: %d \nThe process priority time: %d \nThe process time: %d \n", holder.arrival_time,holder.priority,holder.processor_time );
                    printf("The process size: %d \nThe process scanners printers modems cds: %d %d %d %d\n",holder.Mbytes,holder.scanners,holder.printers,holder.modems,holder.cds);
                    printf("The process location: %d \nThe process pid: %d\n",holder.location,holder.pid);
                    kill(holder.pid, SIGCONT);
                }else
                {
                    // The process is a new procces so it allocates memory and resources
                    holder.location= allocate_mem(&res, holder.Mbytes);
                    alloc_res(&res,holder.scanners,holder.printers,holder.modems,holder.cds);
                    //forks the program
                    pid = fork();
                    if(pid != 0)
                    {
                        holder.pid = pid;
                        printf("New process in que2\n");
                        printf("The process arrival time: %d \nThe process priority time: %d \nThe process time: %d \n", holder.arrival_time,holder.priority,holder.processor_time );
                        printf("The process size: %d \nThe process scanners printers modems cds: %d %d %d %d\n",holder.Mbytes,holder.scanners,holder.printers,holder.modems,holder.cds);
                        printf("The process location: %d \nThe process pid: %d\n",holder.location,holder.pid);    
                    }else
                    {
                        execl(command, "");
                    }
                }
                // Sleeps for 1 second to let the forked program to run for a sec
                sleep(1);   
                // subtracts the processor time by 1 to get remaing processor time
                holder.processor_time = holder.processor_time-1;
                // sets the flag that program is suspended to true
                holder.suspended = true;
                // if there is still processing time is what this checks
                if(holder.processor_time > 0)
                {
                    // pushed the process to the que of priority3
                    push(priority3, holder);
                    // sends a signal to stp the process
                    kill(holder.pid, SIGTSTP);
                    // this is to just make the output more clean 
                    sleep(1);

                }else
                {
                    // if there is no process time remmaining kill the process and free the remaining resources
                    kill(holder.pid, SIGINT);
                    waitpid(holder.pid,&status,0);
                    free_mem(&res , holder.location,holder.Mbytes);
                    free_res(&res,holder.scanners,holder.printers,holder.modems,holder.cds);
                   
                }
                // sets the run time and flag of not execute
                runtimediff =1;
                not_execute = false;
            }else
            {
                // This means that there was not enough resources to start the process
                // sets the flag no resources to false
                no_res = false;
                // pushs the process back to its original queue
                push(priority2,holder);
            }
        }
       // checks if  priority3 queue is not empty and that a process was not run
        if (!(isEmpty(priority3)) && not_execute)
        {
            // pops the process
            holder = pop(&priority3);
            // checks if there are enough resources or if the process was suspended
            if((check_mem(&res,holder.Mbytes) &&  checkresources(&res,holder.scanners,holder.printers,holder.modems,holder.cds))|| holder.suspended)
            {
                // If the process was suspend
                if(holder.suspended)
                {
                    // prints out proccess unformation and send signal to continue process
                    printf("Resume Process in que3\n");
                    printf("The process arrival time: %d \nThe process priority time: %d \nThe process time: %d \n", holder.arrival_time,holder.priority,holder.processor_time );
                    printf("The process size: %d \nThe process scanners printers modems cds: %d %d %d %d\n",holder.Mbytes,holder.scanners,holder.printers,holder.modems,holder.cds);
                    printf("The process location: %d \nThe process pid: %d\n",holder.location,holder.pid);
                    kill(holder.pid, SIGCONT);
                }else
                {
                    // The process is a new procces so it allocates memory and resources
                    holder.location= allocate_mem(&res, holder.Mbytes);
                    alloc_res(&res,holder.scanners,holder.printers,holder.modems,holder.cds);
                    //forks the program
                    pid = fork();
                    if(pid != 0)
                    {
                        holder.pid = pid;
                        printf("New process in que3\n");
                        printf("The process arrival time: %d \nThe process priority time: %d \nThe process time: %d \n", holder.arrival_time,holder.priority,holder.processor_time );
                        printf("The process size: %d \nThe process scanners printers modems cds: %d %d %d %d\n",holder.Mbytes,holder.scanners,holder.printers,holder.modems,holder.cds);
                        printf("The process location: %d \nThe process pid: %d\n",holder.location,holder.pid);    
                    }else
                    {
                        execl(command, "");
                    }
                }
                // Sleeps for 1 second to let the forked program to run for a sec
                sleep(1);   
                // subtracts the processor time by 1 to get remaing processor time
                holder.processor_time = holder.processor_time-1;
                // sets the flag that program is suspended to true
                holder.suspended = true;
                // if there is still processing time is what this checks
                if(holder.processor_time > 0)
                {
                    // pushed the process to the que of priority2
                    push(priority3, holder);
                    // sends a signal to stp the process
                    kill(holder.pid, SIGTSTP);
                    // this is to just make the output more clean 
                    sleep(1);

                }else
                {
                    // if there is no process time remmaining kill the process and free the remaining resources
                    kill(holder.pid, SIGINT);
                    waitpid(holder.pid,&status,0);
                    free_mem(&res , holder.location,holder.Mbytes);
                    free_res(&res,holder.scanners,holder.printers,holder.modems,holder.cds);
                   
                }
                // sets the run time and flag of not execute
                runtimediff =1;
                not_execute = false;
            }else
            {
                // This means that there was not enough resources to start the process
                // sets the flag no resources to false
                no_res = false;
                // pushs the process back to its original queue
                push(priority3,holder);
            } 
        }

        if(runtimediff >= 0)
        {
            runtimediff = 1;
        }
        // checks if the flags to see if list is done is true and sets the loop flag to false
        if(not_execute && no_res)
        {
            not_empty = false;
        }
        // resets flags
        not_execute = true;    
        no_res = true;
    }
    printf("Done");
    return EXIT_SUCCESS;
}
