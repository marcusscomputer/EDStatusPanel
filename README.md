# EDStatusPanel
 A status monitor for Elite Dangerous, written in PHP. Designed for 1080p screens. Fork or download to adjust and/or improve as needed or wanted.

## IMPORTANT
Make sure that the path stated in inc.php is accessible by the web server you are putting these files on. Otherwise the monitor won't work.

The file panel.php is the main file to open the status monitor.

Put the browser that displays the panel to full screen mode so that everything aligns perfectly on a 1080p screen.

Obviously, the game needs to run for this to work.

## Panels
The top left shows your current location info, including the info for your next jump and if it is a fuel-scoopable star. It includes a galaxy graphic showing Sol's position in blue and your position in red. Further you see your current absolute coordinates. Additionally, the distance to SOL in light years (simple vector distance formula for 3D vectors).

The top right shows the current state of events. There are 32 labelled indicators, which have been assigned different colors for their purpose. You can change those in the CSS file. I convert the flags of the Status.json and evaluate the state of each byte to make them light up. Further you see your current fuel as well as the distribution of your Pips.

The bottom left is simply a collection of received chat messages, with the latest message on top.

The bottom right is an exploration log of the current session. It shows quite a number of things, such as FSS results, details of scanned orbital bodies... etc. It also shows if a planet has been discovered previously (D), if it has been mapped with the DSS (M) and if it is landable (L). In addition it highlights if a system scan is completed. Further, it lets you know if POI's have been found on the planet, and if so, how many, plus, their names with distance.

## Web server
My local installation uses PHP 8.0, may work with 7.x also. I have been told that sometimes there could be a permissions issue on the folder and/or files in the web server, should you see a black page when opening panel.php .