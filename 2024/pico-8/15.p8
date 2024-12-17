pico-8 cartridge // http://www.pico-8.com
version 42
__lua__
-- aoc day 15 2024
-- by neil popham

-- 64x64 mode
poke(0x5f2c,3)

data = {
"##################################################",
"#...o.#o#o..oo.o.#..o....o...#.o....ooo.o.o...#..#",
"#o.o.oo.##o.....o....#....#.o#o...o.....o...o..#.#",
"#.o..ooo..oo.o..o..##o..o....oo..o..oo..#..o.....#",
"#...o...oo............#...oo....o.#o...o....oo..##",
"#....#o.o....o.oo....oo..#ooo.oo...o.o.........o.#",
"#.......o.#o...o.#.o#o..ooo.o..#.o.#........#..o.#",
"#..o.....o...o....#......o.##ooo#...o.#.........o#",
"#.#oo.o...#ooo#...o...#o.....ooo..o.........##..o#",
"#o.o.oo.#o....oo.oo.............#..o.oo.....o..o.#",
"#..oo...ooo..#....oo.ooo..o.......o.#..#..#....o.#",
"#.o.......o.....o.o.o.o.................#ooooo.#.#",
"#.#o....#.o#o....o#....oo...oo.o.....o.....#.o##.#",
"#.#o.#..o.ooo.......o.oo#...o.o.o.#o.....o..o#...#",
"#..o#...o.o....o.............oooo....oo.o..#.....#",
"#.o#.oo#o.o..o#ooo...#......#.......o...ooo#.oo..#",
"#...oo.o.o.o#..oo#....o#.ooo.oo#o......#.#.o.oo..#",
"#...o....o#o..o..o.#..oo....o.o.o......#..oo.#.o.#",
"#o.o#oo.oo.o.#...............o....o........oo....#",
"#.....o......o...o.o.o.ooo...o..oo.ooo.oo.oo..#..#",
"#.##...o....o.......oo..#ooo.....o....o#.........#",
"#.oo..o.o...#o..ooo..o..o..o......o........#..ooo#",
"#ooo...oooo#...oo....oo.....o#...o....o.oo..oo...#",
"#..o...o...#.o.##oo.......ooo#...oo....o..o..o...#",
"#..o.#o.#o...#.oo.......@o.....o....#...o....o.o.#",
"#...oo.ooo...o.o..o.....o.o...o.o.ooo.#.ooo.o#...#",
"#.....oo.o...o.o#o...........o....oo#...#..o.#oo.#",
"#.o....o..o..o..#oo#.........oo.#..#....o...oo.oo#",
"#...o#.oo.o....oo............o.o.o..#.......o...o#",
"#.....o#.....o.....o...o.o..ooo..ooo...#.....ooo.#",
"#..o....#.o...o......o..ooo.o...o.o..o..oooooo#..#",
"#o#.o.o..#.....o...o..o...o..ooo.o..oo....o.o..o.#",
"#.#.o..o.o.....#...o.o...oo.oo..#o.o......o..o.oo#",
"##..o.o...............#.....oo...o...#o.o.....o..#",
"#..o.o..#.#..o...o..o..........#.o#o.....o..#..#.#",
"#..#....o.##...oo..o.....o...oo.o#....#o..o#o...o#",
"#o.o...o#o.o.....#.o...o...o.......#.#oo....o.o#.#",
"#.#o...o..o....o...o.............#..o.#.#.#......#",
"#.#...o..#.#...#oo.....o..oo......o...oo.........#",
"#....oooo...o.....o.ooo......o.##..o...o.o.o.o.o.#",
"#....o.o..#...o.o.....#oo.oo.....#...o#o#......o.#",
"#...#.o......o..o..#...o##oo.#...#.o.........o..o#",
"#o.oo..o....ooo...o.o.oo.#........o.oo#o..#.o.#.o#",
"##..#.....o.#o....o#.........o.o....o..o..o..o.#.#",
"#..oo...o.....o.o.....o..oo..o.oo..oo.oo.o...oo..#",
"#..............o#oo......##..#oo#...#.o#.oo..o...#",
"#oo..o....o#.o..o..o......ooo.....#.o.......oo...#",
"#.o.#o.#.#.o.........o#..o........o.o.#.oo.......#",
"#........oooo....oo..o#.o..o.##oo..o...oooo.oo...#",
"##################################################"
}

directions = "ullluuuddruuluuudlluullrurrdduruddlrldddlddrrldrdlruudurdullrrllldllurrrdrruudddrdddldrddrrldllllduurrurddddllrdurddlllduddrlruuuldruulddrdrrrrrrdlrlulruluurlluddlddlrluurdruududuuuuruuldudrurlurrdrdddluldrdrudrluulludrduruudrulluurdduddrurdddlrdllrudrdddrlruldrurrddrrddlurulrdlulrrulurdrrrddddlrllrdlrurlrrdrulrldrdrldlrddrrrldrdrlduurddulrduuuldddlulldduluddldlrdllrurrurdrdldldrlrdrdlrldruudlurudrlrrludllldulurluludduululurudrluurullldrrlrdddldllddrrdruldurdlurdudrdluuuduuddluudrdurudduuudrrrdduluurrlluuudurrrruudldddrdrulurldllrrrdlrlululrlruluuurlrdudlrlddrrrduuuududlrullurruuddddldudullrdlullrldrdulludlldudlrulrrrdrrldddruluuurudrdldurdddddurldrldrrrrrlurrrdduddulrrrudrlddludrrrrdldurruulullduldlullrrllurlldduduululrldrlulurlduudlludrldrlrllrrldlludullulrdddduluuullrurrllllrluuuulurldrluluuuldrldrdluluuuulrrddudrudrrrluldrdududdllruuuddddllddlruuddlldddldudulrdlluuurrlddruulrrdududluulduddddulrulduuudruudduuuudrlddlllruldudurrdddurrudrrldrurrlulullrurdrrduuddrurludlddrllrurllurldrlrulduurullduuudrlrrlldruludluduuuuullruduuruduudrduullrrdlrluulrrrudludlrddrdrldrrlrdudrdddlrluddludrrlludlurdlullruddlrldlrlllluduudurludurdllrluuuuulrdurdlrdrrdurrddldrldddldddldrrdrruruudludururluddlurururldrruulldrdurlllluulldrrrurlruldrrllurllrlluluuullruuddlrddrlrdurllduudurdrrrululdrdruululududuldlrudlrrlrlrdududrdddllluludrulurlrrrlludrrlllluudduuulluruddllududdudrurlrdudrllrrlrrduurdurrlrudduuuurudrurlurluddrrdululrrrdrldrdrrllurdlllurururulrluuulurrrulddrlduddrullruuurlullduuldrdrdurlddldlldduulrrldrldddduullldulrruruluululuduldulruulddrudllrudrrlurrddlulddlrldullurlulddurdrluldlrrudduldlrdlddurulddrrdullrdlrllrdlrrrudrulduluulduurddrlduluddrllurrrurrrlrlududruuddrruldlddrrlldurllrrdruurlurrdrlldddlludulrdlrrldurdrludrdluulrururllrrurrruldduudrdruulduuldlrdrdlduruuurrrllrrudlddrurdddrrdrldlduulrddullldrulludrurldlrruulludurdrrdlrddludrrduruluuulludludlulududdllrudrllrullrdurrrrrruddrrululurrdurrudldrludlrruuddddullrdrrrluddurluddrlrdllddduurddrluuruullrrdrdlrruldulduudulllruuruuuldludluurlllurdrrldlrddrrlduduuruulullldlurdllulllllurudrdrdrlddruddrlrlrluudurlllrdddululrlluudrddrrduuludrldrlrdddurlllrdurulrrullluldrudrlululrddllruuluuddurlduudddddruululluduulldruddlulddlrrdrrulurrlrrluurdddrddududrlrlrudurrddrdudulurlururuuuurlrluruururulllrrurudrdldluddrlduurrdlullllrdrllduuldrrulullrrdrrrlrdrrrldrlulllduldlduudluudullrrdruurlruulrrddllllrrludlrluuldururrrrurrlrdldrlrudllrlrllrdurudruldrrluudrdddududurlrudrldudlrrlludrldludluldudldrluulddldrrllrllluuuuudulduuddrurdudrudlludduluulurulrrlrdlrurdllrrdrrdlluuuuululdrddrrlududdlldduuludulrllldrlrldrlllrdlrlldrlulldrdullurlulurdduullulrdrruulurddrdlrldrdulrrurrlurlulurdrdrudduuludurllrrrullrdurddrdlrrlrdurruuldruuduullrluudluududulrldludrurlrdruulldldldududlluurrrruuudlrurlurldulurlrdrurrururllrrludrdrdrddlruuudurldlluuuudrrddlrdddrlrlururluudldruruudddururlurllududddrdluldduruduurlduluuuruddlurrrdldrrddllluuldllludddddudllldulllrlrdlllurlludlrdrlddlurdrululrulruluudllludrdrrudurruldluudlduudddrduludldduurlrlduluruduulddrdllruulrlurldlddlluurrduurlrlurddlurdlulurdulddulrrrduddurlrdrrrrrrruuudlddrdlrrllduludududdrllrdllrlrluddrudrululldurulrulduduuuullurruddurrulddlurddullrrululddurduudurrllrlrrurddldrrrurrulrrdrdluudruuudlrrulddllduuudrlulldluuulurluuddlddrdrldrlrlddlrrlllrullluurdlluldddrdrrdurdldldrlllduudludululurlluddurldurrrldrurulrrdduuruudldruulddldlddrlllrlddulldrurldrdllrudurlllurdduddluuudrlurldululrudrlduduuuuruuludurldruuurrluuudrdrddlluludluldddduddlddluuuuudllullldudurrlrdurdrdrululurrrdlldurrudddlluuluurudlruurullrdudurrudddrrldurrudrurrudruudrurldullddrlrurlururdruuurldldllrrdlrrudlrdurddrdurudldrrurrldrllldrdlullrddruuudlllrldurddullrdurlrdddduurrrluududdlurrrrluluurrlurdrluuulrddddullldrrlduulluurluuullrlllddluulduldduruurrdluulrlrlurudrrrdurrldlddruruurlrludlrrdruududdrddrlrddllulrdrdrdluruuudurduurluuudrlrduulrrrulduurrulldlluudullrlruurrdrrrldlurdurudlllrururlllrduurrrdududldurdddulrrdruuulrrlrruruuuulrudlrrdulrrrrdluruudrluuuldllduluuluuuulrullddrudduulrludurldurrurlulldruuldlddrlllruuuullurrlddrurdudldudllrruddrlrdurrrrlurdldldulrllllldullurldurdluulruddlluurrruuddlurrrudrlrlrludruurrurdlddlduddlurudrdddrdrrurrllrdrudrlrlrlllrduruuurlurrluddrlrududurrddulrrdllurdrlluddrrrrdrlrllllullrdlldrddullrruuruudurruuldrrdrldlrdrluuldrrdrduduuludldddddludurrdurlrrluldullrdulrllrululurlrdurulllululuddlulldlduudllruluululldrurrluudrldrrlddrrulduudluuddurluurullddrlrudduuuurduudduruurdrlurddlrdlululdduurullrdldrdldudrdurrlrdrulrlurllluruduluurulrrllludrdurdludulddlrrdrrrdrurdrudrllddlrlurllrlulrrdlduuurdddlulldruldudulddlurrruurduduurludrdulrldrrlddrdruuddulurddlurrulldlrlrdludrdrururdludrudllduuurrulurlllrrdrudrudldldlddudlruudrulllluulurulrruddrdluuddrrluddlrdrrdlrurrrrrluululrdduruldrllurddddurduduluuudrlrdlduuudrurldrrdrddruuluudruulrlrrddddddlrddrruludrurllururdudluddulrdrlulluddurldlddlurrldddrruuurdlldulrddldudlllurrldllrdlullullrdlurduululuudduuuuuuddrrlluurrrrrruurulrulddrrllrrlldrrduudluuululudduldlullrrrdldrdrdldlruldudrruudlllruurluudlrrdllludrldlddldrruurdduuurdudduulldudlluuuddudlrlrrrrududruulllurrrdurdrrrdlrduruurlrrrurrrulrddlldrduudlduurrdurrlludlddduudrrllddurrrududlrrlululdullduurudlllrruururrdrlduudrrdrulruudrddldrulurudrrurllulrlddlrrllrdrrrlruduudlurrdrddudllddrududurdurrrlruuuddduuurrrruuludulrldrduudddrrlllddrrldrdrlrldurlduudllluluuurdrrlluuuldrdrlllrllrduulllluudlullrulddlururulluluurdudlrlddddrddldddlrullduulllrurlludlduudlrldldrdurldrddruddrrlrrrrdrrrrlllrldrlurlrrdrllrururuuududduruulurrrrrrlluldldudllrrurrllrdrdudrulrrruuldllddluldulldldrdrdlllluldlrdullldrdlddludrdrurdldlurllrdldulrduduulrdrdurduuulrrddrrrrdluururuuluuurdlldurldludddudrudrdlrdudldrrddluudddudduldurururdrddurdldruldrulrdlllrrdrlruudrlududldrllrurllulddrddrrllrrllrlulrululdlldrrudluulllruulddllduludurruudrurdlrdrlllrdrudrudduuurllrdudrrududldulllullurlrldrullurdlrlrrlldullrrllrdrddduurulllrlrrrlrlrrullludurrrrurldrrlduuudrlluddrlrudruuruuddudrrddlrrurldldulllrrurudrdldddlrdrululdrdurrldullldludludddrdlurlllllllldurrlurrdrlddddrldullrurudddrrrdldlldldrrrrdludrurddrrrrluurrlrdrrluuurlrduulrrlrrulruuurldlrlurlludddddrrudrudlldurldrullllulruldurruuurduluruldrlllrrdlduudllrrdulrrudlrrurulrrddrllllrrdldrllrlrrddlrududdrluruuulurlrlldlrllrldduurllduluurldurrruluduurduldlldudlddlruuurlldllrrurrluudrdlrlrldldllrulrllduululdddrldrrlrlururudlddddrrulrludrlulrrldlrdllrdrurlduludlduddddurdlrullrdddrllruuluruullluurudlddlduuldludrrdurululdulllrruuuudrrrrldrddddrrlulurlrrrddlrduluuldldrlrddrdrdudrdrrrdludduulrdrdudlruddlldrrurududdulduddrduddurdruuurddrrrlrdrruuluururddlurddrurudrrudlrdrdrrurulludllurludlduuluddlllrludurrddduuurrrrurddlldrrrrdlluulrlddldlldrdrulrluudlldludldlullrldudlulldulldlluldrulrrllruruurrdldllruduudlddlllrrldlrulddrdrdludluuudlrurrlurulurlddllurddluuuddrlludllddudududurdrdruddlrruluuduurlllrlduuuldllrdulurdlruuddllrdddduuulrrdlllldllldurddruulurrdlrrrrlulrlldruruldrrlluurdlrdddrdrrurdrurrurllurulludrrllullulldrulrdllllurlrluuulrludlldlludlrrlulddrlddruududrduluurdurrururuududuurlldllrddudddduduldrrudduudlldllldrdrudddrlrruuuldurdruddrrudrrddlruuludrurldrddudluuuddrruddrllulrluluurddrdrurdulrdudurudllddrudldulddllulrrruuuurdrddrururuuuuurrdllrrurrdddddrddlddrurrluduruddulduuuudldllllddudrlurllluuuuuludrdduuurllurlruludrurrdlrdlurudllulududdldudldddluduluruuuduldlluudrlrrluuludlrruldruduldrllludulruddrldurudduduuuldrrllulrddrlrllrurdldlldrdlruldldduluudrudrruullduldldrduruurlduduudrluudlrlrlurdrdurrdrrurulrrluullrrudrluluruurullrrllurlrruuduuududddduurrdrrlrulddluduuurrdldlrrlrlddluululdlllllrdrlddrddrdrlrrudrlluuldrduruuulurdlrdlrrrruddlrduduuurulurullrldullrlldduudllluludddrrrlurddrdldrrdrdrdudlrdrduudrurrluddllurllruddrdlrurrddrdurrururluddlluludrrlululdlrudrldluudrdldlululdddrduudlrdrruururdlrrduulrlduuduuddlrllrlrdddlurudduldrldllluudddulurdduuululdruudluurdudddulddudrdullldullllldlrruldurdruldruruludruluulldlrdrdudlullrlrdduddldrrrludrdulrrldrudrdllurudlrdrddrrudduduldlrrrduddduurdrludluullduudluduudlurllllrlruruddrdurrulrddrrludlrrllldudddulurdlluddrdllruruldrruuuurlrlrdludluruldllrddlrrlrurulrululurrrdlurdrurldlrurrdrdrludllldululdrurruluuuuldudddruuluuddluuruluudllldudrdrdlurlllrdddrdldrrlruuddlullldrrdruuuurrldulldlllrlrlduldulrdudurldrldlldldrduldulrlldruddudulrullldluulddrduulldrdlrrrulurlrrdlrurududddddddldlllurldrldlrldldruldrlrlrruuddlrudulurlluluddrrruurdlrlrludrlrulddrrudlddrduudurdullrrluluulrddlulllrdddddrrurldrlrlururruuldldrlrddldddlluruddlurdllddllruurlrrlluulrudlluldurudlrdddluruurrudulururddldrdudrdlrdduduululdrrdldrluddrdllrlududrrluuldluulruluuulurrludurddrrururrddrrdlulullruurudududdrdrurllrlludrudrdllrurlrdrulurulrrllrddluuuddrluudluuldrrudrlddlruudldllrldlrddlulrrrddurrldrrrrulrdrlrurrldrrdullurlluurddduuurdlddrdlurrddldlrrduurdrrrlldurruddrluulrdrdruluuuduludurrldrldllrullldrrrluurrdrduududddrrddrrdudrdlrddrdldluddluuruuludddlrrudlddrulrluduudurllddrdurldrurulldlulrurdldrdlldrrrdldddurludrrrllrldrduurlurlldrdduulllurrulludrldulrrlrludlldlrddrlrurludlddurlurllluddldlrrulllldrruuuldurrrlrrlddduudddlrrlrrrluurruuludldullllrrlddrllddrdrrruudlrdudlldluddrludlrurdruurruldddddrdddluldulldluulrudllurdurdlrrdrluudlrldududulrrddlluldrluulurlrrluurduudrulrddududludlllddurrrruudddurrddddllrllrrudlurddlrrrulduddddlrrurddlrdluudurrdldulrdlrllrduruduuruludulrdululrulruurdrdlrdllrrudrrrlddrddrurdrldludllddddldldrrllurrdduudllluduldldldddlruddrlurdlddluuurlddddllrrrruddudrulllrurullduuruddrdurlddrrdluududulllurlllulurrlrddrluurdrruldurdldrludurrrdrululurrdlduurdulrruudllrlldlduuudululduullrdrluurdddurldduudullrdrrludulddrdduudrdluluruddudlluulrlrrlruddlrrluudullulurrdrdudrdrluullurlllrruulrldludrlrldlrulldllruudrulrlrlrlrrddulddldldddlluldudlduulruddlurrduurlululldrrrrlllruldldllrudrlrurdrrddulllldduuudlllrlulldlrdddlurrdddllrlruldlduuluudrllrrrulddldlllrrrdullldrrlrrllddrrdurdlrrlrdduuldrdlrrurludrruuurrrlddldrudlrlurrullrdluurrllluulrlrlruddddlllrddrrdlrrdlddlurlrlrllllrlluudrrrrlluudrlddrudrllulrluddrrrrllrlllddrlulrdurulludrulllullrrrurrrudurrduddurlulrduluruluuddruldrurrurrdludrurrldllldrdrlrllrdlrrddrddddlduludrludrluddurlrrldrduuduuddddrdlurdrrllurllrrdulrlrddllulrlldlldddudlldrrrlruuldlulururrllrudlrrurlldrlulrrdrdruludllurudddrrrddrddrddduduuddruuullurdrlurrdlludldulrlddddrldrdddludddllllrdurludrrlduruudrldrddurdrdudrduuulurrrddrddldddrlrurldlrldlrllullllrlldurrrdrluddrdrrdluulrdrlrurlrdldddllludrdrlduuuudurrdrldulddlrululurrrudduldrdllurlrlrrdldlrldlluudlulllddllrrdrrullrrdrlllrrrduulrurrruludrddurllurlurrddullrduludruuuullrlururluuuuluddlduudllduddddrddduddldrdlruddddrdudrlrrrululrlllldllrdrudddurluddudlrdudrrrrdulrddrlrdudlldrrrldrdrdduurlrludurrddduurdudllrrrdludluudllddurlddruldrduldrrlrurlddduddrrdrdldlrddudlrrurdrlulurdruruuudllruuudrlrrululdrrdllrduudlludulldlrddrrluddruldudullurlluulrlrululldldrddlulddulrldurluldrrlrludrlddlluduurrdruurrdrrddrurddurduulrrrrulrrrduuuurddrluluuulrldruudrrlduulurrrdurlrluluruldurduddldluudlldurdurrurdduudlrrlurruuluduldludrrldurdlruddduduuudrrrddrrrrlrrurldurllruurlrlrdrudluddlruddlldddlldlrrdrrudrlllrluurllduddlrurlrdulldrddddullddldldrurrrululrrdrrllrllurllrulurdlrrrddulddddllrrllrldddldrullrrduduuullddllldurrrururlrdrruurddrulrlludullldldurdudrudrrrdluruurdrlrulludrurruulrulduluddrllrdrluddrrudrruudlrlurluudrdudrrdrllludlurlulullullrurludrrrdulrrdruuuldlrdlllrluuudldrdruururlrrllurlrddruurrllllulldurdlldlrrrrrdrddddlrurdurdrrulluudrrlrdrurrdulddllldrduulrrddudrluruddlrulrdrrudrdrdrdrludluurldllurrrdduurdddrddrddludlldrlrlurdlududdllrrlduuudddldrdrurlldrdudrruuruurrrudldurrudrluruddrudurdrlrdldruuuuludruruuurdrdrlurluduuurdrdlrdldrddlludduudlrlddrrlurrrulrdddludrdldllluddulullllrllduldlrudurdrduudurrudrluudrldduldlulududddrlullrurdduudluudlddlulldluuulududrlurruurdluululuulurduddrrdrdduludrluurlllldurdudldlluudluudlduddlrdurddldlurludldldrluddllddlludrddrrludullrlurrrdludldduulllrrlrdluuuldluuuulldrduuddrruurululllddullruulrluulrluurldlldlrludlrruurrrduuulrullllrluulddruduurddulruuulllluurlrlrduurrrurdrdduldulrldullrrlldulldrrurdrrdddrlldlrududddllulrlllldudrdlluurdlddluuudduluddrulruludullduruddlrrddurdulrrlrlrlrludurdlldddrrudrdrlldlrlddurrruurllluuuudlrdulrrruddrrrrldudlrldrullddrulurdrulududludrrldurrllrlruldldlruldrldlrllldrlurruurdlldlldudduruurrrulldudrduddrddrrddluulrlluuulldrrdurrurrldldudlurrdlulddrduddullldlulllrldruudrudurrddudlrdudllluuurududduurrrurdlrlurlldlrrudludllullrlrruddruurrrdrdlldddudlrddrurrdllruddlllrddrlrrululruuuduududullurdlullurlrdullldlrlllddrurrrdudlrldrudrdrduuddudduruuuruduludrrrludddluruluddrldllrruuurdrdlrdudlduuluuddrrduludulrddlldlrrddrurllruurrurudlurulrrlrdrdluuullulrrluudrrurdldluruuddrrulrrrlldruuuluruuurdurruurlrduuduuuurllrluuldurrurddlurddrrlrdlurruludrldullddruldddulluudurudlddrurllllrdrurrddrurdurudruldurrrduululdlluldlrldlddudruuddddudrudldruruuuddddururdurrddrulduludrlldurrurururuuudrldrllrdruruudrrrurrlrruludlddduulrrdduuduudllldrulurddrrdluluddrruurdlrdrldurdrllrudrudllullrdurlduruuurlrlddduluuuurduduluudrlurddurrrrllulrldrurlrllrdudullluulllduuruudrrlrrlduruldruuluuldrdulrrurlulurduddlulrulldrlllrrurdudrruudrdrlduluuudrrdluludrulrdrdllrrrdlllurduulludlldrluddurrurrulldldrululuruuudrlurrdlddlluldulluldduududrrldrrdlrdrurlrudrrdlrdldullrlrudllrlurddlrlurrdrldddlrluuludlluuulullrrlurudrlullruurdrdduruddrrldllulllluldudddddrluuluuruurlrrurlrddlurullrdluudrrllludluurrulurdlddurluddlruurdlrudrllulrlrudddluldruuruudlurlldurdllluudldldrdlurrdudruuuluuldrrrlllludlrddldldudldruudlurdrdurdluruulrldldluuduurruurlruudlduuruudrurdudrrududurdlurlrrruldduuluruldurulrllddrluuulrdudldruudrudrlurrddrlldlllrdlddllurrlrruluurulldduurlldrrlrrlrduuuruludluludududruluuruudlurllldrrruddrrdrdldlrllddlddludulrulrdduuudududulrrrdlddrrrurrlullurdddlurrrrrrrdurruurrudrururduruuuulurrdurduldrlduuluudrrlrlluuulduldrdlulrllrulldluldlllrdrlrdduldrdrrdrrurulrrururluududuuluruuldrdulullrulrrlldldrluurdrlurudlurduldlrllrrlrlluudrrdruludldurdrrluuuudruldrrrurduuldrrldddlluulddddlududrudurldrrlluuulldrluulrdrllldlrduuldluuldduurrlrdudluurdrrrdlulrlurllldddrlrldudulrrdlldlldulurlrududdlrdlullulurdrlulduuuluudululduuuudduuulrlurldddrurrdulduurlduudullllllldluudrdduuuldlrdduudrrrddllddrddrudrurlduuurrdrrlrudulrlrrdudrulrrllllrrrrdlduuduludrllrurrlruldrdlrdddurrlddrudlllrddrulduuluulrlrdulrdurrlrdlurllruldldlulldllludlldlrdlluuldudrludduudlrlulrdllllurrlrldllruuulrruuuldrrdulluruldddluldlrldullllurldldldlldllduldrddruudrlrdrlrrlllduuddlrlulrddruudrurdldddlduduulududuludddrrudrldlllrurllluulurdrddrdrdddrllullddlrdruldlrlllrruddrudldrulrrrulddudrrldllrluruurdrrrudlrurlrluduululruldudldlllrlurddudurldlulllurddurlluulurrldulrrdlrlllrlduudrrududlduurruurrrrdrllruduururduulrrruulduldrlrrrdulurudludlururllrddldururrlddldldddrudlruruuduruluudrdldrrullrrlllluddduduurddrlluduulrrullluldrllllrrrluulrdududdulllllurrlrluullduduuruddrlrurllruddldlluurrdudrlrrrdldluduurrldluduuudddlrdrlldullddllurrdludlddudurulllrdurrrrururllrldduudrluuuduuullrllluururudrrllrlulrdddrduruurlurdrrlududdurruurrdrdllruullldlrruddrudurrdllrrlllrurruruddlruuuddlllddduldduullduuuuluududrddrdlduudduldlrddrrruluurruulrldldrldduddlruddludddurdddldldudrrrldrlldduluddluuddlurrurrrlurduddudluuurrrldddrdrdddrdudldduldudduulrdurduuuuulldlrlrdulrudrurdlurululduuuddululllllluuuldulrrrddulrrdddddlrddrddldlrlulluuruddlldrlduuulldrlluuddluurrrlllrurlluulrddururudddudrlddudruulduuuulruldlrulurdlrrruruudllrrldrlrlddrdlrrduddlrdduudlruduruuuuuulrrldrrululdrluddulrrrruurldludluuurdllddrlrlrlllddullulrrrurlddrddulrrduludduduuurlduddrrlurulurrrrdrddduuurdddurrrdlllruulllululdurrlullrddrudrluuudllrrrurldddlrrudululuurlruuuluulruuddludrlurrdururdulddrrrrddrluuluddluluudrrduuldrrrudlduruurudrrdlrurululuuuulurrurdldruurlrrulduddrludlrrllrullrlldrdruuldrrrrdurlruulrrddlurudrrdrlldrudrlurdlldurdllllrudlullrurlduldluruduluuurlluldddrdrrlldrdrdrludlulurururlllrururuludrduurllrudddullddululdlrdldddrulrlrrrlllrdlurrrdrlrrlddldrududrlllrdddruuluuldrurrdlurludlrdudruulllurdrudlrduululrrlldldrdlldurduluulllldudrlrdrdduuuruddrrrrdrdduldurllulurrduudllrdrludrudllrlrldlurdududduludlllurrldururrldlrruuddrlllulldlururulrurdlurdluluulrdlldrldruurlllrlrlllrlurddluurrulldululuruudrdluudrldrluudrrurrdduudrurrrdlldrruluduurldlrldlrrdrdudrdluurdurldlldrlrulrrrululldlrulduuuuddulrrudlduddurruddruldrudddddrurullddrrddddurlulrllldurdlrururdlddlldrduddurddudrrudddlrullduldrrulduludrdurluuurdulluulldddrdllurdudruuddlullldddrlrrduluurldludlrurdrdllluluuururddlllrludlrulduldduudrduudrrulddlrururruuldrdullrurrdudlrrllddurllruluruldrurrddduldduuurldddldudulrruudrruulllrlrdudrllrruddddlddldurrrdrdrllrruduurdlludrlludluddrdullludlrlururdurllldlulllurlldrrluudrrllrdldluldruulldudlrrrrdrduruuudldlldrluuuuuulrddrldluldrruldllldldulurlrrdrdluuuddluduldlrlrrrurlulllddurrlurrdlrdlrulrdulurllrlulrlldulrdrulrurldurllurulldrlllrrlrdrllrdlurdldlluulllulrrrurrurdurulrrrllrluruuruddlurlulullrddllludluulluldrlllulluddrdudrudlurudddrlddddrdlrruuddddduudldllrlrllrurrrddluudrulddulrdudlrrrrrrurrdlulrrllludrrdulddrlrrlluluuurdldurlrdurrddrluddrddrduurllrddrdrrurdldudrruudlurrlrudddrurruldlduuduurlrrrulrdulrlurldudluurrulrrldrldulrluuudruuururllduddrrdrduddldudrrrllruudrlldldlddrrlurlddlrdrullurudddurrrrddlldllrduurruddddrdruuullludlurrdrludududrllluululuudlurrluduulduudulrlruluuuudlddddlrrdudldllrruulldrdlldldrrrlurduudrrduududurrrllulrdudruuuduururrlurrdurldudrlurrrdddrldrdlrluldllrullrlulurluulluldlrurlurlurllrdrrlrdurddddrllurldruuldrrldrlrudluulrudrduruludruururuudrurrdldrrluurrdrllludurrudddludrddldulduddulluuduuduurrrulrdrulrduruddrulurrddrlddrlddllulrduruduulrllldlllrllrdududldlrrrluldulurdllurlrrdddlurrddrduluuluulrrullurluludrdudllrduuuulrdrrudulluldudrurlrrrlrrldllulrduluuuruuduullrudllrlrudrrudllurududldluuudrrldlurldudlrdllulddulrlddrlrrurrurrruuududrdddddrrurrdurdlrdrlrlrlrdrdurdrdduulururlulduudrlrdllludrrurddrdlduludludlrlddluuulldrdldudurrdluduuudldruluurldrdulllruldrrulddduduurldurrrddrrulurddrlduurllrduduurduurudllddrlurluuruulullrrurdlddurluddudduuddrururlrrllurllulrluullulrldrduuuurlddrudddlldlruurlluddlurulullldluddlrrdldduruululrururlurrulurrdlrduuddllddurdlrlrrlururlllrrudlrrduuurduuluruudrrllrdulddlruuulruulrrrduruddlrddrldddurldrrluldrrrdlldrurlldlrdrlddlduddlurrlruduuurrrruudrdrurrudrldrullldurdlrdldldudurrlurrurrduurddllrdlldrllrddudrlluldrluulrrrrlddrrdlddudrduddluurluduuruddrdrulrllulrrdurrruuruuldrldurrlurlludrdrldldururuurdrrlrulllldurrdudrddrldldruurdrlurduddldurrllurluudrlullrduuddllrruuluddullurrudurlduurruuddurdldrrlddldllldlrrlurrullulrurrrdrdudrdruurdduldrrrldulrlldurduulrrllduudrduddrrrrldrdlllluruuudrddrdrdldruulduuuulrulldurulrulrdlddlrdudrdrdrudlrudllurludrdudldrrrrddrdurdlluddulrulududddrrdrllurdrdrddrulurruludrldlluldlrudlruurrlrurdrlluudududlllldrldrrrrruulrrdlruruldrrrduudurrdrulllllrllddrddrrrrlurrdduuululrlurulddrrlluuuruldlrldlurdlulurdduddluldlulrudurrrdrrdullrudluuurudldrrrllrddllrrrrdrllrldullulrluudddlllluurulrrlrudurllrluullulruurdullrruduurrlludddlurrlruullrulurrruulrullllrrldlduluruldlurrrududuudlrllldrrduuddrdrdlrrdrrldlrrrudrldurudullrlruulrrrddrulruuddlludldlurrrllrldudduddlrururrrdrdrlldururrldrlluurlurulddrlldlrdulrdruullrrdruuuudrrrldrurdluuulldrlddldrdddlrddrddurlulldlrrudlluudurdlrrruudddululrurrulrullrlurrdrrrdllrlldrdruuurrdllrrrddrruurrlrlrrulddrdurrrrdrrdddlrllrlrluurdrrlluudddrulrrrldrudruuuduldrrdrruluulllldlrrdddruurrddrlrlrurrrlrlulududdrrdldlludrrrdurdlrluudrrududlrrlrlddrrdllrdduuurdulldlluduududllurrudduudrlrllllurrdduuldlllrllluuududdullrlduududuurudllrudruruluullrrudurdllrurdrrllrddrruudrlululrruuruuuldlurrluurdlulrduulrrdrudlldllururdrllrrulrrdllrlruddlddlrldludrddlrrdddullrdlrrrduuuuuuluurdruluurddrddldluduruulduururdudruuldddrduduudurdulruldrdrddlluduluurrduudrlrlurlluddudurrurrrdduluudlrruuudllduurldlduddldrurllrdldddrlrddurddddldldrrrudulludruuurdldurrddddrlruudduudrurdduddulduluudduuurllrddudruddldrudlluluurrdddrdrlulrrlddullrddudulurullddulludrlulldrudrldduluurdrdddlrludldddlrrluulurudlurlludluuulrurduuruuddrlulrrdudrdurdllulrrddrudrludululduddluurdrrulddlldddurlddldrrdlurrduludldlldurrlddrlrdudlludldlrurluuduluurrrdluldlldlrrluluuddlldrrllldllruddulrrlruuldrlruudldrddrulrullruudluulludlluurludldrdddddrudluurrrrudddldrurldulrlrullluuullrdddrrluulluudurduludlrdrlduuudrdrrrddrurrdldrdrlrludurdlruluudrulrruldruruudrdudluurrllr"

offsets = {u = {x = 0, y = -1}, r = {x = 1, y = 0}, d = {x = 0, y = 1}, l = {x = -1, y = 0}}

grid = {}
boxes = {}
x = nil
y = nil
done = false

function move_box(b, ox, oy)
    local nx = boxes[b].x + ox
    local ny = boxes[b].y + oy
    if grid[ny][nx] then return false end

    for nb, nbox in pairs(boxes) do
        if nbox.x == nx and nbox.y == ny then
            vacant = move_box(nb, ox, oy)
            break
        end
    end

    if not vacant then return false end

    boxes[b].x = nx
    boxes[b].y = ny
    return true
end

function _init()
     for r, row in pairs(data) do
        grid[r] = {}
        data[r] = split(row, "", true)
        for c, v in pairs(data[r]) do
            if v == '#' then
                grid[r][c] = 1
            elseif v == 'o' then
                add(boxes, {x = c, y = r})
            elseif v == '@' then
                x = c
                y = r
            end
        end
    end
    data = nil

    count = #directions
    height = #grid

    i = 1

    extcmd("rec")
end

function _update()
    if done then return end

    ox = offsets[directions[i]].x
    oy = offsets[directions[i]].y
    nx = x + ox
    ny = y + oy

    if grid[ny][nx] == nil then
        vacant = true
        for b, box in pairs(boxes) do
            if box.x == nx and box.y == ny then
                vacant = move_box(b, ox, oy)
                break
            end
        end
        if vacant then
            x = nx
            y = ny
        end
    end

    i += 1

    if directions[i] == nil then
        done = true
        extcmd("video")
    end
end

function _draw()
    if done then return end
    cls(1)
    o = 6
    rectfill(7, 7, 56, 56, 0)

    for y, row in pairs(grid) do
        for x, _ in pairs(row) do
            pset(x + o, y + o, 8)
        end
    end

    for b, box in pairs(boxes) do
        pset(box.x + o, box.y + o, 12)
    end

    pset(x + o, y + o, 7)
end
