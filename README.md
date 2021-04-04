# WebData-Leecher
Custom web scraping tool for extracting data from DotaBuff

## About
This is a web scraping tool I've made specifically for scraping data out of a dota 2 website in order to use for the training of my AI model. I haven't used any 
external libraries as I wanted to make everything by myself for the learning experience. 

Currently, it works as intended. I did have some problems with bypassing the website's CORS policy, but that was mitigated by creating an httpUser class. There was another problem
with the maximum requests in a certain amount of time, after 20 requests the scraper is blocked for a little while but I managed to mitigate that by using VPNs.

