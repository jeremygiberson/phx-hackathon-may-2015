# Phoenix Innovation Games 2015
[![Code Climate](https://codeclimate.com/github/jeremygiberson/phx-hackathon-may-2015/badges/gpa.svg)](https://codeclimate.com/github/jeremygiberson/phx-hackathon-may-2015)

## Reminder Service
How often have you put something recyclable into the waste bin because the recycle bin was full?
Reduce contaminate waste by reminding people to take out their garbage on time!
   
### Game Plan
  * Prompt users for their address
  * Recycle existing [service](https://apps-secure.phoenix.gov/fls/AddrSearch?callback=jQuery110207062696553766727_1431658675507&address=625+South+5th+St&returnas=json&layers=pw_collections&_=1431658675508) to get garbage/recycling days 
  * Display collection days & prompt user for email to schedule reminders for the day before
  * cron job `php public/index.php reminder wednesday` to send reminder emails for thursday pickups

## Refuse Bot
Ask Refuse Bot how you're suppose to dispose of something and it will tell you how! Probably.
 
### Game Plan
  * Build simple database 
    - categories of waste & method of disposal
    - noun to waste category association
    
  * Parse sentence for nouns
    - for each noun regurgitate category and method of disposal
    - for unidentified nouns, "I don't know, ask me later" and queue noun for identification
    
#### Web Interface
  * Prompt user for Refuse Bot question
  * process via bot service
  * display results
  
#### Twitter Bot Interface
  * Response to UserStream message events
  * process text via bot service
  * response tweet result
  
  `$ php public/index.php twitter stream`
  `$ php public/index.php twitter handler`
  
  
## Reclaimable Notice (idea)
Notify US about a reclaimable you have for pickup -- and we'll come get it.
Ie, when you have something that can be reclaimed but don't have a way to transport it.

## Neighborhood Competition (needs extra data)
Need to know routes -> neighborhood association
Need to do more frequent container samples from each neighborhood

## Electric Garbage trucks
So much money and waste lost to power vehicle traffic 65 miles x 125 trips per day.
That money and waste can be reclaimed with an initial capital investment in Electric garbage vehicles.
Duh?
  * Work with schools to build a new electric garbage vehicle
    - ASU
    - ATI
    - etc
    - Sponsor the program in exchange for patent on designed vehicles
    - Once we have vehicle designs, sell electric garbage vehicles to other cities.
  * Work with Tesla to produce a new vehicle
  * X-prize like competition for a new vehicle

## Reclaiming Recyclables from Refuse
  * Add an open door policy to transfer stations
    - Allow people to show up and rummage through the garbage and pick out recyclable items
  * Add cash for your recyclables facility to the way station, pay for cans, bottles, etc
  * Presents a job opportunity to homeless to already do this process less efficiently, rummaging through private garbage cans throughout the city.
    - Instead, encourage them to come to transfer stations, sort out recyclables and pay them for what they pick out. 
    
## Double Recycle Bin
  * With the insurance of online ordering & delivery companies like Amazon more and more people are getting overwhelemed with cardboard boxes.
  * Its easy to fill up the recycle bin with shipped cardboard boxes. 
  
  
