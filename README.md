# Coding Challenge

The main goal of this challenge is to get a sense of your coding style and choices.

The code challenge does not involve any exotic or bleeding-edge technologies, tools, etc. and that’s the point: We’d like to focus on your code style and not get distracted.

On that note, we’re also not looking for "rights and wrongs", and there are no "trick parts" in this challenge. We would merely like to get a more profound impression of how you write code.

That also allows us to have a more fruitful and constructive discussion at the technical interview. We’re not fans of white-boarding at interviews, so we’d much rather have some concrete code to talk about. We think that makes the interview much more enjoyable and productive.


# Your challenge/task

Develop a referrals feature using Laravel 8 and React. This feature is heavily inspired by Dropbox's referral https://www.dropbox.com/referrals so it would be a great reference for this task. For every successful referral (meaning you get a user to sign up using your referral link), you will get one point.

## Task Specifications

* Allow users to login and register
* Develop a new page `<domain>/referrals` to show a form where the user can input multiple emails to invite.
* This page should be written in react or should use a react component where the input is a multi-select _similar to dropbox_.
* Send an email notification to the invited email. The email's content doesn't have to be fancy, it can contain a simple instruction and link to the registration page with the referral link `<domain>/?refer=<code>`
* Track successful referrals - when a user signs up from a referral link, increase the number of referrals count of the referrer.

## Notes
* Users who are invited already cannot be invited again.
* Existing users cannot be invited.
* A user can have a maximum of 10 successful referrals.

## Bonus Points
* Create a new page for an admin user `<domain>/admin/referrals` that shows the list of all the referrals made in the system. Columns can be referrer, email referred, date, status

## Invite Email
**Subject**
<first_name> recommends ContactOut

**Body**
<first_name> has been using ContactOut, and thinks it could be of use for you.  
  
Here’s their invitation link for you:  
<referral_link>
  
ContactOut gives you access to contact details for about 75% of the world’s professionals.  
  
Great for recruiting, sales, and marketing outreach.  
  
It’s an extension that works right on top of LinkedIn.  
  
Here’s their invitation link again:  
<referral_link>

