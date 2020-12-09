import core
import re

def get_bags(data):
    bags = {}
    for rule in data:
        matches = re.findall('(?:(\d) )*(\w+ \w+) bags*', rule)
        contains = {}
        for i in range(1, len(matches)):
            contains[matches[i][1]] = int(matches[i][0] or 0)
        bags[matches[0][1]] = contains
    return bags

def can_contain(bag, bags):
    if "shiny gold" in bag:
        return True
    for child in bag:
        if (child in bags) and can_contain(bags[child], bags):
            return True

def total_bags(bag, bags):
    total = 0;
    for child in bag:
        if child in bags:
            number = bag[child]
            total += number + (number * total_bags(bags[child], bags))
    return total;

def check_1(bags):
    total = 0;
    for colour in bags:
        can = can_contain(bags[colour], bags)
        if can:
            total += 1
    print("%d matching" % total)

def check_2(bags):
    total = total_bags(bags["shiny gold"], bags);
    print("%d in total" % total);

data = core.load_data("7.txt")

bags = get_bags(data);

check_1(bags)

check_2(bags);
