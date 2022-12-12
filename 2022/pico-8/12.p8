pico-8 cartridge // http://www.pico-8.com
version 16
__lua__
-- advent of code 2022 day 12
-- by neil popham

poke(0x5f2c ,3)

local data={}
local q={}
local cell,h,g,s,e,map,mx,my

function _init()
 raw={
  'abaaaaacaaaacccccccccaaaaaaccccccccccccccccccccccccccccccccccaaaaaa',
  'abaaaaacaaaaccccaaaaaaaaaacccccccccccccccccccccccccccccccccccaaaaaa',
  'abaaacccaaaaccccaaaaaaaaaaacccaacccccccccccaacccccccccccccccccaaaaa',
  'abaaaacccaacccccaaaaaaaaaaaaaaaaacccccccccccacccccccccccccccccccaaa',
  'abacaacccccccccccaaaaaaaaaaaaaaaaccccccccccaacccccccccccccccccccaaa',
  'abcccacccccccccccaaaaaaaccaaaaaaaccccccccccclllcccccacccccccccccaac',
  'abccccccccccccccccaaaaaccccccccccccccccccclllllllcccccccccccccccccc',
  'abaaacccccccccccccaaaaaccccccccccccccccaakklllllllcccccccccaacccccc',
  'abaaacccccccccccacccaaaccccccccccccccccakkklpppllllccddaaacaacccccc',
  'abaaacccaaacccccaacaaaccccccccccccccccckkkkpppppllllcddddaaaacccccc',
  'abaacccaaaacccccaaaaaccccccccccccccccckkkkpppppppllmmddddddaaaacccc',
  'abaaaccaaaaccccccaaaaaacaaacccccccccckkkkpppuuuppplmmmmdddddaaacccc',
  'abaaacccaaaccccaaaaaaaacaaaaccccccckkkkkoppuuuuuppqmmmmmmdddddacccc',
  'abcccccccccccccaaaaaaaacaaaacccccjkkkkkooppuuuuuuqqqmmmmmmmddddcccc',
  'abccccccccccccccccaaccccaaaccccjjjjkoooooouuuxuuuqqqqqqmmmmmddecccc',
  'abacaaccccccccccccaacccccccccccjjjjoooooouuuxxxuvvqqqqqqqmmmeeecccc',
  'abaaaacccccccacccaccccccccccccjjjjoootuuuuuuxxxyvvvvvqqqqmmmeeecccc',
  'abaaaaacccccaaacaaacccccccccccjjjoooottuuuuuxxyyvvvvvvvqqmnneeecccc',
  'abaaaaaccaaaaaaaaaaccccccccaccjjjooottttxxxxxxyyyyyyvvvqqnnneeecccc',
  'abaaaccccaaaaaaaaaacccccccaaccjjjoootttxxxxxxxyyyyyyvvqqqnnneeecccc',
  '1bcaaccccaaaaaaaaaaccccaaaaacajjjnnntttxxxx9zzzyyyyvvvrrqnnneeccccc',
  'abcccccccaaaaaaaaaaacccaaaaaaaajjjnnntttxxxxyyyyyvvvvrrrnnneeeccccc',
  'abcccccccaaaaaaaaaaacccccaaaaccjjjnnnnttttxxyyyyywvvrrrnnneeecccccc',
  'abcccccccccaaaaaaccaccccaaaaaccciiinnnnttxxyyyyyyywwrrnnnneeecccccc',
  'abccccccccccccaaacccccccaacaaaccciiinnnttxxyywwyyywwrrnnnffeccccccc',
  'abccccccccccccaaacccccccaccaaaccciiinnnttwwwwwwwwwwwrrrnnfffccccccc',
  'abccccccccccccccccccccccccccccccciiinnnttwwwwsswwwwwrrrnnfffccccccc',
  'abaaaccaaccccccccccccccccccccccccciinnnttswwwssswwwwrrroofffacccccc',
  'abaaccaaaaaacccccccccccccccccaaacciinnntssssssssssrrrrooofffacccccc',
  'abaccccaaaaacccccccaaacccccccaaaaciinnnssssssmmssssrrrooofffacccccc',
  'abaacaaaaaaacccccccaaaaccccccaaaaciiinmmmssmmmmmoosroooooffaaaacccc',
  'abaaaaaaaaaaaccccccaaaaccccccaaacciiimmmmmmmmmmmoooooooofffaaaacccc',
  'abcaaaaaaaaaaccccccaaaaccccccccccccihhmmmmmmmhggoooooooffffaaaccccc',
  'abcccccaaacaccccccccaaccccccccccccchhhhhhhhhhhggggggggggffaaacccccc',
  'abaccccaacccccccccccaaaccccccccccccchhhhhhhhhhgggggggggggcaaacccccc',
  'abaaaccccaccccccccccaaaacccaacccccccchhhhhhhaaaaaggggggcccccccccccc',
  'abaaaccccaaacaaaccccaaaacaaaacccccccccccccccaaaacccccccccccccccaaac',
  'abaacccccaaaaaaaccccaaaaaaaaacccccccccccccccaaacccccccccccccccccaaa',
  'abaaaccccaaaaaaccccaaaaaaaaccccccccccccccccccaacccccccccccccccccaaa',
  'abccccccaaaaaaaaaaaaaaaaaaacccccccccccccccccaaccccccccccccccccaaaaa',
  'abcccccaaaaaaaaaaaaaaaaaaaaacccccccccccccccccccccccccccccccccaaaaaa'
 }

 for _,line in pairs(raw) do
  add(data,split(line,'',true))
 end
 raw=nil

 for r,row in pairs(data) do
  for c,value in pairs(row) do
   if value==1 then
    s={x=c,y=r}
   elseif value==9 then
    e={x=c,y=r}
   end
  end
 end

 h={97,0,0,0,0,0,0,0,122}
 for i=65,122 do
  h[chr(i)]=i
 end

 map={{x=0,y=-1},{x=1,y=0},{x=0,y=1},{x=-1,y=0}};

 mx=#data[1];
 my=#data;

 printh(mx)
 printh(my)

 g={}
 for r,row in pairs(data) do
  g[r]={}
  for c,value in pairs(row) do
   g[r][c]=32767
  end
 end

 g[s.y][s.x]=0

 process(s.x,s.y)

 extcmd("rec")
end

function _update60()
 cell=deli(q,1)
 if cell==nil then
  printh('ge '..g[e.y][e.x])
  return
 end
 process(cell.x, cell.y)
end

function _draw()
 cls()
 for r,row in pairs(data) do
  for c,value in pairs(row) do
   if g[r][c]<32767 then
    pset(c-3,r+10,1+flr(g[r][c]/30))
   end
  end
 end
end

function process(x, y)
 local ch=h[data[y][x]];
 for _,offset in pairs(map) do
  local valid=true

  local px=x+offset.x;
  if px<1 or px>mx then
   valid=false
  end

  local py=y+offset.y;
  if py<1 or py>my then
   valid=false
  end

  if valid then
   local char=data[py][px]
   local ps=h[char]
   local pg=g[y][x]+1

   valid = ps<ch+2 and pg<g[py][px]

   if valid then
    g[py][px]=pg
    add(q,{x=px,y=py})
   end
  end
 end
end


