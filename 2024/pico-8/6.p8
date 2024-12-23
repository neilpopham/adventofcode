pico-8 cartridge // http://www.pico-8.com
version 42
__lua__
-- advent of code day 6 2024
-- by neil popham

local data, x, y, o, ox, oy, done, offsets, active

function _init()
    extcmd("rec")
    data = {
        "......#...........#..............................#..............................#...........................##...............#....",
        ".............#..............#........#......##...................................................#............##...#..........#...",
        "...#..................#..............#.........#...#.........................................................................#..#.",
        ".....#..........#...................#.....................#..........#...........#......#..#...................#..................",
        "...#...............................................##..................#............#.....#...................#...................",
        ".#.#..#...................#.##.................#..........#................................#......#.........##..................#.",
        "....................#...................#....#.........#....................#....................................................#",
        "..........#......#...................................................................................................#....#.......",
        ".#...............#.........#...........#...............#...................#......#...............................................",
        "............#...........#........#..##.......#........#.....#................................##...................................",
        "...................#.#.............###.................##.................#.......................#.....#..............##.........",
        ".........................#...#............................#......#.......................#........................................",
        ".....................#..............................................#.......#......##......................................#......",
        "............................#.#............................................................................#.................#....",
        ".#.....#.......................................................#..........#.......................................................",
        "..............#..............................#.....#....#........#....................#....#.#...........#.#..................#...",
        "........................#...#...##......#...........................#.............#............................#..................",
        "...#........................................................#...#...........................#...#...............#........#........",
        ".........#..#..........#.....................................#..................................................................#.",
        "...........................................#.........#....#........................................#..#...........#...............",
        "..#..........#...........................................................................................#..............#.........",
        "...#.......#......................................#...............#...............................................................",
        ".#........#......#.#....................................#...#...........#..........#........#.#.......#.......................#...",
        "......................#...........#......##....................#..................#......#..............................#.......#.",
        "..............#......................#..............#...#.#............................................................#.#........",
        "..............#..................#...#..................#...#.....#...#...............#...........................................",
        ".............#............................##..#...#...............................................................##..............",
        "..#............................#.......#.#....................................#...................................................",
        ".......#.....#..........#......#.....#...................................#...........................#......#....#..............#.",
        ".#.................#.............................................#................#.............#.....#....................#......",
        "..............#.........#..#.....#...........#..............................#.................................#............#......",
        "....#.#............#............................................................#..........#......................................",
        ".........................................#.......#......#....................................#.....................#...#......#...",
        "....#.............................#....................................#..........#................................#..............",
        ".........#..#......#..............................................................#....................#..........................",
        ".......................................................##...#........#......................................................#.#..#",
        "..........................#.......##..##................................................................................#.........",
        "..................................##..................................................................#..........................#",
        ".#..................................................#..............#.....................#.....#..................................",
        ".......##........................#......................................................#..........#..............................",
        ".........#....#....#.........#.#........................#...#.....................................................#.....#.........",
        "....#.............................#....#....................#.....................#.....#......#.....................#..........#.",
        "............................................................................................#..........#......#...................",
        "..................................................................................#..........................#.#.....#.........#..",
        "..................................................#...................................................#......#.....#............#.",
        "..........................................^#................................................................................#.....",
        "...............#..........#.............................................#.....#....#...................#................#.........",
        "#..#....#........#........#.........#.......#.................#.......................#.#.............#...................#.......",
        "..#................................................................#......................................#.......................",
        "........#......................#.....................##.#..........#.............................#.............................#..",
        "....#..........#........................#.........................................................................................",
        "......#...#.#.#.........#.................#.....#.....#...#......#..................................................##........#...",
        "...#....#....................#...................................................................#......#...............#.........",
        "..#.......#.........................#..........#........#............................#......#....................#................",
        ".................................#.......................................#....................................................#..#",
        "......................#...#........................#.......................#.............#........................................",
        "......#.......#...................................................................................................#...............",
        ".............#............#......#............................#...........................................##......................",
        "..........................#.....................................................................................#.................",
        "....#..............................#......................#........................................#....#...........#.............",
        "................#.......#.........................................................................................................",
        ".............#............#........#.....#.........#.#.#............................#..........#..............#....#.......#.....#",
        "..#.....#...............................................................................................#...............#.........",
        ".......#...........#............#................#.......................................#..........................#......#......",
        "..........#........................................#......................#............#....................................#..#..",
        ".......#......#..............................#........................................................#.#.................#.......",
        ".#.................#..#.....................................................................................#...........##........",
        "#...................................#........................................#..............#.##........#..#.#.............#......",
        "......#...............#........#....#.........#.........#...#.......................#...........................#............#....",
        "...#...................................................................................#.......................................#..",
        ".....#.......................................#................#...............................................................#...",
        ".#................................................##................................#....................#...............#........",
        ".................................................#..#..................#.......#........................#...............#.....#...",
        ".....##.#.............................#.....................#................................................................#...#",
        "...........#....................#...........#...............#.................................................#.......#.......#..#",
        "........#....................................................#.....#....#.........................................#.....#.#.......",
        "...............#..........................#............#.#.................................................#......................",
        "...........#......#.....................#...................................................................#.#..............#....",
        "......#...#.........................#..........................................................#..................................",
        ".....................#................................................#..#........................................................",
        "..............#.................#............#....................#.#.......................................#............#........",
        "............#.....................#................#......#..........................#.#.........#............#...................",
        "........................................................................#.....................#...................................",
        ".............................#....................................................................................................",
        ".........................#...#..........................................#............................................#............",
        "..#...............................#.....#.....#.............#.......#..#.................##.#.......................#.........#.#.",
        "......................................#...........................................................................................",
        "...........#.....................................#................#...#.........................#........................#........",
        "..#...#..#..........................#.......#....#......................................................#................#........",
        ".....................................#...#.#........#...............#..#......#.....................................#...#.........",
        ".#..............#..............................................................#.........................##......................#",
        "..........#..................................#....#.........#...#.#..........#...#...................................##...........",
        "...............#.....................................................................................................#............",
        ".#.......#....................#...#..........................#.#...............#......................#........#.................#",
        ".............#....................#........................#..................#......#....#....#..................................",
        "........#..............................................................#.....................#....................................",
        ".......................#..............#.............#......#.........................................#.........................#..",
        ".......#.......#.#........#.......................#..#.......................................................#.#..................",
        "...............#..#....#.......................#.....#..............................#..................#.....................#....",
        "......#..............#...........................#............................##...........................#......................",
        ".......................................#........#................................#..........................#.....................",
        ".#.....................................#............#.............................................................#..#............",
        "..................#..................#.........................#............#..........#.........................#...#............",
        ".......................................................#..............#..........................................................#",
        "...#....#..#...#..#...................##....................#.....................#...................#.....#..........#..........",
        ".......................#........#....................##.................#.......................................................#.",
        "........#.......#.......................#.#......##...##........#..##.........................................#...............##..",
        "....#..........................#.........##..#......#...........................#........#........#...#...........................",
        "...#..........................#.....#.....................................#.......................................................",
        "....................................##.......#..............................#.............#...#......#.............#..............",
        ".#..............................#...............................................................................................#.",
        ".....#................................................................................##.....#..............#.#...................",
        "...........................................................................................#....#................#................",
        "...#..#...................................................#....#.......#.......#.................................#........#.......",
        ".#....#....................#..............................................................................#.............#.......#.",
        ".........#.................#.......................................#...........#......#.......#............#............#.........",
        "........................................#...............................#.........................................................",
        "..............#....#......................#..........#........#.....................................#...........#..........#......",
        "......##....#.............#..........#......................#.........................................##..........................",
        "....................#.............................#.....................##.#..........#..#......................###.........#.....",
        ".#.......................................##........................#.....#.....#..#...............................................",
        "..............................#............................#.......................................................##.............",
        ".........#.............................#..............#......#.....#..............#.#............................#........#....#..",
        "............#..............#.............................#..........................#.............................#...............",
        ".................#...........#..............#.....#..............................#.............#................#.....#...........",
        "........#.....................#........#.....................................#..........................#......#.#................",
        ".....................................................#..#........................#.##..#.........#................................",
        "......#..............................................#..........................#...............................#..........#......",
        ".................................................#.................##.......................#...................................#.",
        "....................#.....#.......#.............#................................#..........#...#................................."
    }

    for r, row in pairs(data) do
        data[r] = split(row, "", true)
        for p = 1, #row do
            if row[p] == '^' then
                x = p - 1
                y = r - 1
            end
        end
    end

    offsets = {{x = 0, y = -1}, {x = 1, y = 0}, {x = 0, y = 1}, {x = -1, y = 0}}
    d = 0
    done = false
    ox = -1
    oy = -1
    o = 2

    cls(0)
    for gy, row in pairs(data) do
        for gx, v in pairs(row) do
            if v == '#' then
                pset(gx - o, gy - o, 5)
            end
        end
    end
end

function _update60()
    if done then return end

    local nx = x + offsets[d + 1].x
    local ny = y + offsets[d + 1].y

    if data[ny] and data[ny][nx] then
        if data[ny][nx] == '#' then
            d = d + 1
            d = d % 4
            pset(nx - o, ny - o, 7)
            sfx(0)
        else
            x = nx;
            y = ny;
        end
    else
        done = true
        printh('done')
        extcmd("video")
    end
end

function _draw()
    if done then return end
    pset(ox - o, oy - o, 1) -- 2?
    pset(x - o, y - o, 12) -- 8?
    ox = x
    oy = y
end

__sfx__
000100001c050130500a0500040000400004000040000400004000040000400004000040000400004000040000400004000040000400004000040000400004000040000400004000040000400004000040000400
