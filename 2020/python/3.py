import core

def check(trees, dx = 3, dy = 1):
    total = 0;
    x = dx;
    width = len(trees[0])
    for y in range(dy, len(trees), dy):
        if trees[y][x] == "#":
            total += 1
        x += dx
        x %= width
    return total

trees = core.load_data("3.txt")

total1 = check(trees, 1, 1);
total2 = check(trees, 3, 1);
print("%d for %d, %d" % (total2, 3, 1))
total3 = check(trees, 5, 1);
total4 = check(trees, 7, 1);
total5 = check(trees, 1, 2);

total = total1 * total2 * total3 * total4 * total5;

print("%d trees in all\n" % total)
