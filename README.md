# EDStatusPanel
 A status monitor for Elite Dangerous, written in PHP. Designed for 1080p screens in the four-panel-view in panel.php, and for 7 inch screens with a resolution of 1024x600 connected to a Raspberry Pi.

## HORIZONS / ODYSSEY COMPATIBILITY
I have tested the panels in Odyssey and they work as they would in Horizons. Frontier added a second Status Flags section (Flags2) which mostly contains information about on-foot events. The ship and SRV info remained the same, hence no compatibility issues.

## QUICK START GUIDE
If you want to hit the ground running:
- Install XAMPP (Apache Friends) on the computer you are running Elite Dangerous on
- Download this repository as zip file (click the green "Code" button and Download Zip)
- Place the content in the the htdocs folder of where you installed XAMPP - for example, C:\xampp\htdocs
- Rename the folder from "EDStatusPanel-main" to something nicer, say, "ed" or "panel"
- Open the file "inc.php" in a text editor and adjust the resolution to your screen, also adjust the folder to where your Elite Dangerous Journal files are stored
- Open the XAMPP control panel through the Start Menu on Windows
- At the Apache entry, click the "Start" button
- RUN THE GAME and enter it in any mode you like (doesn't matter if Solo or Open)
- Open a web browser on any machine (Raspberry Pi, laptop, doesn't matter) and navigate to the IP address of your computer, and the path to the panels, for example: http://192.168.1.46/panel/
- Select what you want!
- You can find the IP address of your computer by opening a Command Prompt in Windows and typing "ipconfig"
- If everything went well, you should now see a live-updating panel. Congrats!

## IMPORTANT
Make sure that the path stated in inc.php is accessible by the web server you are putting these files on. Otherwise the monitor won't work.

The file panel.php is the main file to open the status monitor.

Put the browser that displays the panel to full screen mode so that everything aligns perfectly on a 1080p screen.

Obviously, the game needs to run for this to work.

## Panels
The top left shows your current location info, including the info for your next jump and if it is a fuel-scoopable star. It includes a galaxy graphic showing Sol's position in blue and your position in red. Further you see your current absolute coordinates. Additionally, the distance to SOL in light years (simple distance formula for 3D vectors).

The top right shows the current state of events. There are 32 labelled indicators, which have been assigned different colors for their purpose. You can change those in the CSS file. I convert the flags of the Status.json and evaluate the state of each byte to make them light up. Further you see your current fuel as well as the distribution of your Pips.

The bottom left is simply a collection of received chat messages, with the latest message on top.

The bottom right is an exploration log of the current session. It shows quite a number of things, such as FSS results, details of scanned orbital bodies... etc. It also shows if a planet has been discovered previously (D), if it has been mapped with the DSS (M) and if it is landable (L). In addition it highlights if a system scan is completed. Further, it lets you know if POI's have been found on the planet, and if so, how many, plus, their names with distance.

## Web server
My local installation uses PHP 8.0, may work with 7.x also. I have been told that sometimes there could be a permissions issue on the folder and/or files in the web server, should you see a black page when opening panel.php .

To be more precise, I am running an XAMPP installation on the machine that runs Elite Dangerous.

## Raspberry Pi (display only!)
If have added a new file: pi.php . This file can display all parts of the above mentioned panels, however it is split up into the four parts. Please note that this is designed to run on full screen 7-inch-displays with dimensions of 1024 x 600 pixels. This allows for panels to be mounted to your desk for example.

Fuel bars and pips have been adjusted accordingly. The galaxy map has seen a complete refit compared to the four-panel-layout in panel.php . I will eventually merge that code into the normal panel too.

Also, all panels update every two seconds - except the location panel. In order to decrease CPU load, there is a timer in the code which checks every three seconds if you jumped to another system. If so, the map is reloaded.

Every system you visit is recorded in the data/data.json file. So in time, it becomes your own out-of-game journal of systems you have visited, and/or planned to visit.

If you have a route set, it will automatically be displayed in the galaxy map.

While the Location panel only can only display this one page, the other three have links on top to switch between them. The following switches are implemented:

- pi.php?panel=location - Shows the location panel
- pi.php?panel=status - The status panel with indicators, fuel, and pips (links on top)
- pi.php?panel=comms - Chat messages of the session (links on top)
- pi.php?panel=exp - Exploration data of the session (links on top)

Just to get the obvious out of the way: the Pi needs to have a graphical desktop environment and a browser, such as Firefox (recommended), Chromium, etc. Navigate to the local IP and pi.php with the corresponding switch to see the panel you want.

In my case, I have two identical 7 inch displays connected to the Pi so that I can display the location on the left, and the other panels on the right.

## 3D galaxy map
For the 3D map to work (which I will implement in the four-view-panel too), I needed to merge nearly everything from another project into this one.

I have made a few changes to the minified JS script in order to ease the CPU usage on the Pi as follows:
- Instead of 10,000 random star sprites being generated, this number is reduced to 3,500. 
- The scale factor (as it is called in the code) at which the view switches to an empty black view with only a grid has been significantly reduced so that it almost never switches into that view. This is done so that the map basically looks cooler and retains the fog and star effect when zoomed in to a local area

Source of 3D map: https://github.com/gbiobob/ED3D-Galaxy-Map