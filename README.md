# Phoenix Innovation Games 2015

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