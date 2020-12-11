import core
import re

def test(data, alter = False):

    if alter:
        jmp = []
        for l, line in enumerate(data):
            matches = re.search('^jmp', line)
            if matches != None:
                jmp.append(l)
    else:
        jmp = [999999]
    max = len(data)
    for j in jmp:
        a = 0
        l = 0
        done = []
        while l < max:
            matches = re.match('^(nop|acc|jmp) \+*(\-*\d+)$', data[l])
            done.append(l)
            if matches.group(1) == "acc":
                a += int(matches.group(2))
                l += 1;
            elif matches.group(1) == "jmp":
                if l == j:
                    l += 1
                else:
                    l += int(matches.group(2))
            elif matches.group(1) == "nop":
                l += 1;
            if l in done:
                if alter:
                    l = 999999
                else:
                    print("Line #%d has already run. Accumulator is %d" % (l, a))
                    return
        if l < 999999:
            print("Code complete. Accumulator is %d" % a)
            return

data = core.load_data("8.txt")

test(data, False)

test(data, True)
