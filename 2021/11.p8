pico-8 cartridge // http://www.pico-8.com
version 29
__lua__
--
-- by neil popham

function round(x)
 return flr(x+0.5)
end

function lpad(x,n)
 n=n or 2
 return sub("0000000"..x,-n)
end

function storedigits()
 cls()
 print("0123456789",0,0,7)
 pixels={}
 for n=0,9 do
  pixels[n+1]={}
  for x=1,3 do
   pixels[n+1][x]={}
   for y=1,7 do
    if pget(x-1+n*4,y-1)==7 then pixels[n+1][x][y]=1 end
   end
  end
 end
end

function drawstoreddigit(d,x,y,c,w,h)
 w=w or 4
 h=h or 4
 for px,a in pairs(pixels[d+1]) do
  for py,_ in pairs(a) do
   local x1=x+(px-1)*w
   local y1=y+(py-1)*h
   rectfill(x1,y1,x1+w-1,y1+h-1,c)
   --pset(x1,y1,9)
  end
 end
 return w*3
end

function drawstorednumber(n,x,y,c,w,h)
 w=w or 4
 h=h or 4
 local s=tostr(n)
 for i=1,#s do
  local w=drawstoreddigit(sub(s,i,i),x,y,c,w,h)
  x+=w+2
 end
end

function _init()

 storedigits()

 data={
  "5483143223",
  "2745854711",
  "5264556173",
  "6141336146",
  "6357385478",
  "4167524645",
  "2176841721",
  "6882881134",
  "4846848554",
  "5283751526",
 }

 data={
  "5251578181",
  "6158452313",
  "1818578571",
  "3844615143",
  "6857251244",
  "2375817613",
  "8883514435",
  "2321265735",
  "2857275182",
  "4821156644",
 }

 for y,row in pairs(data) do
   data[y] = split(row, "", true)
 end

 ticks=0
 total=0;
 limit=100;
 flashes=0
 turn=0
 totalat100=0
 offsets={};
 for x=-1,1 do
  for y=-1,1 do
   if not (x==0 and y==0) then
    add(offsets, {x, y})
   end
  end
 end

end

function _update()
 if ticks%3~=0 then return end
 ticks+=1
 if flashes==100 then return end
 turn+=1
 printh(turn.." "..total)
 queue={}
 flashes=0
 for y,row in pairs(data) do
  for x,_ in pairs(row) do
   data[y][x]+=1
   add(queue, {x, y})
  end
 end
 while #queue>0 do
  item=del(queue, queue[1])
  local x=item[1]
  local y=item[2]
  energy=data[y][x]
  if energy>9 then
   data[y][x]=0
   flashes+=1
   for offset in all(offsets) do
    oy=y+offset[2]
    if data[oy]~=nil then
     ox=x+offset[1]
     energy=data[oy][ox]==nil and 0 or data[oy][ox]
     if energy>0 then
      data[oy][ox]+=1
      add(queue,{ox, oy})
     end
    end
   end
  end
 end
 total+=flashes
 if turn==limit then
  totalat100=total
  printh("total:"..total)
 end
end

function _draw()
 cls(0)
 local cols={1,2,2,8,8,9,9,10,10}
 local x,y,row,energy
 for y,row in pairs(data) do
  for x,energy in pairs(row) do
   local sx=x*10
   local sy=y*10
   local size=energy==0 and 10 or energy
   --if (energy>0) then
    sx+=(ceil(5-size/2))
    sy+=(ceil(5-size/2))
   --end
   rectfill(sx,sy,sx+size,sy+size,energy==0 and 7 or cols[energy])
  end
 end
 if turn>=limit then
  --drawstorednumber(totalat100,30,91,8,4,4)
  --drawstorednumber(totalat100,30,90,14,4,4)
 end
 print("turn:"..lpad(turn,3),11,2,10)
 print("flashes:"..lpad(totalat100==0 and total or totalat100,4),64,2,11)
 --print(ticks,0,120,1)
 ticks+=1
end
