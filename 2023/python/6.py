#!/usr/bin/python3

import math
import time

def find(distance, time):
    start = math.floor(time / 2)
    current = 0
    total = 1
    diff = 1
    while (total > current):
        current = total
        for offset in [diff, -diff]:
            if ((start + offset) * (time - (start + offset)) > distance):
                total += 1
        diff += 1
    return total

s = time.time()
total = find(204171312101780, 34908986)
e = time.time()
print(total)
print((e - s) * 1000);
