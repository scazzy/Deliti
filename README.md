# Deliti

Opensource Web Conferencing and Virtual Classroom software

--------------------------------------------------


![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/ROOM_DESKBOARD.jpg "Deliti")




PS ~ This code was built in 2010. Built in PHP 5.3. The code doesn't use an MVC structure or any framework.
Released with a thought of helping someone to know how a conferencing platform and its different technologies work together.
Please read the NOTE at the end of this doc.
I'd try to put a working demo of this online soon.

--

### Technology used:
- PHP
- MySQL
- Red5 Media Server
- Java, Servlet, Beans
- Apache
- Tomcat
- Flash
- ActionScript 2 & 3

### Features:
- Fully featured conference room (handles simultaneous multiple rooms)
- Whiteboard (Real time writing)
- Live audio and video broadcasting, with recording option
- Participant Chat
- Document sharing
- Geolocation
- Meeting notepad
- Old meeting archives
- Open meeting search
- Guest registrations


--
--------------------------------------------------

Copyright © by respective authors (see below). All rights reserved.

####Authors/Developers
[Elton Jain](http://eltonjain.com)  - elton@welbour.com

--
--------------------------------------------------

Code files: 
Project code divided in two parts, PHP server side, and Red5 streaming side

* **_php** folder : PHP code to be placed in the AMP server (Apache, Mysql, PHP) web directory.
* **_red5** folder : Red5 code to be placed in the Red5 server path.

--
--------------------------------------------------

#### Screenshots:

![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/ROOM_DESKBOARD.jpg "Deliti")
The main Conference room, called 'DeskBoard'

![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/whiteboard_fullscreen.jpg "Deliti")
Using Live Whiteboard in Fullscreen mode

![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/fileuploader.jpg "Deliti")
File uploader for live document sharing within the room

![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/videocast_players.jpg "Deliti")
Video broadcasting players, one for host and other for attendees

![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/searchrooms.jpg "Deliti")
Searching Open conference rooms / classrooms

![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/home.jpg "Deliti")
The start page of a registered user, with options to create new room, or check the archives

![Deliti whiteboard](https://github.com/scazzy/Deliti/blob/master/screenshots/invite_participants.jpg "Deliti")
Invite participants

--
--------------------------------------------------

#### This project was developed by [@eltonjain](https://twitter.com/eltonjain) in 2010, and is no longer supported. Though any doubts or questions can be asked in issues.

--

> Note:
> - The PHP version shall be latest with respect to 2010, hence you might need to handle some depreciated methods if faced.
> - The developer might need some basic idea of how to use the Red5 server.
> - Edit the configs according to your environment, database, and namespaces you create
> - The chat script is very basic one using direct db transaction. Recommend to implement jabber or similar technique.
