# Building Sybil

Okay, it's been a bit of time since I've done any of this from scratch, so I decided to go ahead and document the creation of a one-person software project that uses some basic quality assurance techniques to ensure that it actually works, and does what it says it will do.

The process I'm using is officially called _My Process_. Yeah, just basically thought about how I'd do this and this is how I'm gonna do it. You probably have a way better process, like Extreme Programming or Scrum or Kanban, or whatnot, but this is my process and I made it up all by myself, and I love it, so be kind.

To help you orient yourself, within My Process, I've made a map.
![my process map 1](https://i.nostr.build/vCL4WKEcQJqmq3il.png)

I've fiddled around with some libraries, did some research of similar systems, rapidly prototyped some of the modules and got constructive feedback on them, but this time is for real. This is the first product iteration, which we will call the **Minimum Viable Product** (MVP).

![Note to self](https://i.nostr.build/uuCtzsGOg5wpvyhM.jpg)

People keep insisting that this sort of stuff is "asking too much" or "way too hard for a beginner", but I'm not a dev (I'm a tester) and I'm about to prove that someone who writes crappy code can actually do this, simply by thinking through the steps and following directions. And I'm going to time the effort, as it progresses over the days, so that you get an idea of how long this took me. (You'd probably be much faster, since you aren't blogging along and don't have to think up the order of the steps.)

The beauty of this system, is that you can iterate from here, refactoring and refining the code, and expanding the feature set, without worrying about it breaking. You can "learn to code" _afterward_ because you have setup a sheltering development environment that is like a cocoon around your #smoldev self.

To do all of this, we will "think like a genius" also called "whole-to-parts thinking". We will begin with an overarching, inspiring concept (the entire system) and then wittle it down to the tiresome details, with the smallest, most-tiresome detail being the lines of product code.

That's right. Coding comes **at the end**. Remember, I already built a couple of smaller prototypes, so I've already established that I know how to type commands into a computer, that do _something a bit like this_. So, I have nothing more to prove, on that front, and can go about the business of crafting a production-ready codebase.


## Step 1: Project Kick-off

![my process map 2](https://i.nostr.build/gxYEcrnV6FfC6WVq.png)

### Define the scope

The first thing I did was come up with a name and select a picture representation of my system. Yeah, a picture. As in, a drawing.

It's this:

![Sybil thinking it through](https://i.nostr.build/8o38CGwWpjkqlqQV.png)

It's a painting, by [Waterhouse](https://de.m.wikipedia.org/wiki/Datei:John_William_Waterhouse_-_The_Crystal_Ball.JPG), that I am using to symbolize a **Sybil**: one of the famous women who prophesied the future, in ancient Greece, such as at Delphi. They didn't have crystal balls, but *How cool are crystal balls?* The crystal ball stays.

Mostly, a Sybil did a lot of research and reading of faces and histories, and then she'd tell people what her predictions were for whatever they were interested in (the weather, the next war, upcoming marriage proposals, etc.) Her job, in other words, was to talk smartly about things in public.

People usually skip this step, but this helps me figure out the scope of the project. Imagining my software project as a Sybil means that I know what the software should do, and -- more importantly -- what it shouldn't do, which gives me a rough feature set:

* write informative texts, that people can use as a reference (wiki pages `kind:30818`)
* write articles, that people can discuss (long-form notes `kind:30023`)
* write indexes that pull together information into bundles (modular articles `kind:30040`)
* announce where people can find one of the above (notifications of a new text `kind:01`)
* search for those four event kinds and display them, so that you can check your work

That's it. All a Sybil did was talk smart, write smart, and read things smart people had written. So, that's all my software will do.

### Define the user

This will help you to narrow your scope, even further.

Who will be the primary sort of user targeted by your application? Don't just say, "myself," even if it's true. Instead, think about _what sort of role you are in_ while you are going to be using your application. 

#### Authors

In my case, I will be wearing the role of _author_. When I use Sybil, I will have come up with a complicated text, that I want to publish, and Sybil is going to help me do that. There won't be much interaction, between the app and I, just one simple command and basta.

I am not expecting any "normal" social media consumers to run this application, and it doesn't need high usability for the MVP, so I can postpone anything fancy for a later iteration. What I do think is essential, is the ability to promote some new text I've written, by publishing a kind 01 note linking to the full event. (This event, in fact. More later, when discussing _increment goals_.)

I'm going to assume that the user is a Nostr power-user and therefore capable of understanding some json, so the graphical user interface (GUI) I'll use, for now, will be [Njump](https://njump.me). Later iterations might open up [Alexandria](https://gitworkshop.dev/r/naddr1qvzqqqrhnypzquqjyy5zww7uq7hehemjt7juf0q0c9rgv6lv8r2yxcxuf0rvcx9eqy88wumn8ghj7mn0wvhxcmmv9uqq5stvv4uxzmnywf5kzlpr50c), but let's keep it simple, stupid (KISS) for now.

#### Publishers

Another hat I'll sometimes be wearing, when using Sybil, is that of a _publisher_. This means that I'll be taking texts that someone else wrote, possibly even entire magazines, books, or libaries of books, and importing them to Nostr, with my npub signing the event.

That means that Sybil needs to be very sleek and easy to use when mass-producing events, and it shouldn't be prone to causing relays to rate-limit the publisher's npub.

#### Readers

I'm going to stretch the use case out a bit and assume that some people will use Sybil to read things. I'd just like to keep that option open, to expound upon in a later version, and because it's the easiest way to manually check your work.

That means that Sybil needs to be able to find things to read and somehow display them in a human-friendly format.

![UseCase diagram from PlantUML](https://i.nostr.build/nvX1y9ZifywO3N7C.png)

### Define the environment

I've decided to use the [PHP Helper library](https://github.com/nostrver-se/nostr-php), that I utilized for my prototypes because:

* I really like [PHP](https://www.php.net/) (stop laughing), 
* the prototypes worked and the library didn't do anything weird,
* I have had a positive experience communicating with the main developer of that library, 
* I want more practice with PHP, in advance of building something more complex with it, and
* I want to give my colleagues some practice with doing a PHP code review, covering a really simple set of functionality.

I will also be using:

* [nak](https://nak.nostr.com/), to make some shell calls for advanced Nostr-y stuff,
* [phpunit](https://phpunit.de/index.html), to write the unit and integration tests, 
* [plantuml](https://plantuml.com/), to come up with some standard UML diagrams,
* [composer](https://getcomposer.org/), to help people figure out what to install, 
* [yaml](https://serverpilot.io/docs/how-to-install-the-php-yaml-extension/), to allow for manual editing of configuration files,
* [json](https://www.php.net/manual/en/book.json.php), for machine-to-machine communication, and 
* [monolog](https://github.com/Seldaek/monolog), so that the logging can be handled over multiple channels.

This should allow me to get everything done, the way I roughly envision it happening.

I'm not a fan of the idea that you should write out every little detail, before selecting a stack, as you probably already know enough at this point, that you can just hit the ground running. As you will have a test suite, you can always choose to replace the entire source later, after all. The most important thing, at this point, is to just keep up the momentum and get the first iteration out before you get bored and wander off to fiddle with something else.

### Define the toolchain

The code will be: 

* written using [VS Codium](https://vscodium.com/),
* managed locally, in [git](https://git-scm.com/), 
* published on [GitHub](https://github.com/SilberWitch) (and elsewhere, but that's not part of this article), 
* tested locally on [Jenkins](https://www.jenkins.io/),
* reported over [Allure](https://allurereport.org/) (just because I like pretty things), and 
* discoverable with ngit, over [GitWorkshop](https://gitworkshop.dev/).

Why bother using an automation server, like Jenkins, if I'm just testing locally? Because I will eventually be testing locally and remotely, testing on different [Docker](https://www.docker.com/) containers, running bots, etc. Once you have an automator set up, you'll think of a gazillion uses for it, trust me. I know it's kinda hard, but YOLO.

![Do hard things.](https://i.nostr.build/nEweeRBmoISqPZVB.png)

### Define the design

#### Architecture

This is going to be a command-line interface, or CLI. I thought about doing a GUI (just so that I could say that I've built one), but it actually doesn't pay into the Sybil use case, GUIs eat up time during the maintenance phase, it would reduce the ability to batch-import, and it's redundant with Njump and Alexandria, so I'm just gonna skip it.

#### Pattern

Okay, this is the point where I tend to hit a wall, as I'm definitely not a software architect. Luckily, I know a few. Well, I've read their books and stuff. So, I'm just going to select a completely random design and go with the [Command Pattern](https://designpatternsphp.readthedocs.io/en/latest/Behavioral/Command/README.html). That might end up being overkill, but it gives me a chance to practice with interfaces, so whatever.

May change later, dunno.

#### Folder structure

I'm going to do the folders in classic PHP-style, with a `src` folder, containing the executables, including a subfolder for `tests`. The user files that Sybil will pull, to process, will be in the `usr` folder, other libraries will be in `vendor`, and I'll need some other stuff, too, that'll be stored in the root folder.

#### Naming convention

> There are only two hard things in Computer Science: cache invalidation and naming things.
> 
> -- Phil Karlton

I'm going to try to be classic here, so I googled PHP standard naming:

* function and variable names use underscores_between_words
* class and file names will be in PascalCase
* methods (functions belonging to a class) are camelCase, and
* constants should always appear in ALLCAPS.

### Step 1 completed: 8 hours

Phew! I'm exhausted.
Yes, this took 8 hours. Yes, I didn't write a single line of code. Yes, it was worth it. 

I have figured out, roughly, what I'm going to do, who I'm going to do it for, what I'm going to need to do it, how I'm going to do it, and I have an inspiring picture in my mind of Sybil proclaiming wisdom over Nostr.

I also eliminated a bunch of other features I was considering, but that don't fit to my defined scope. So, I don't have to build those features, now, which saves me lots of time and headache, and reduces the risk of the dreaded **feature creep**.

Always remember: "good apps" are not necessarily large. They are focused, elegant, and reliable, and structured so that they can smoothly interact with other apps.

![The UNIX philosophy](https://i.nostr.build/8MvK1Uns1VpXHGh3.jpg)

My legs ache, my eyes hurt.
Time for lunch.

## Step 2: Project Setup

![my process map 3](https://i.nostr.build/pEq57t4u0sBmIUx8.png)

### Install stuff

Okay, I've had a chance to recover from the tour de force from this morning, so let's start with something really hard, now that I'm mentally fresh and over the initial trauma.

I call this _the installation orgy_. I go ahead and install anything and everything that I plan on using. I just hack away at the command line and the composer.json, going down the list I came up with, until everything at least works with a little test run.

The crowning glory, is seeing my Jenkins run it's first pipeline and produce a little Allure report. Make sure you use `sudo systemctl enable jenkins`, to get the server to start, when you turn on your machine, and you might have to change to a different port, if you have a relay running on `localhost:8080`, already. I just moved Jenkins to `8081`.

![jenkins](https://i.nostr.build/kJM8mWJWJQPA0pPi.png)

### Step 2 completed: 5 hours

This can take between an hour and a week because Linux.

It took 5 hours. I don't want to talk about it. I'm just grateful that it wasn't worse and that I've put it behind me.

Check everything into git, as the initial commit, and then let's call it a day.

## Step 3: Project Planning

![my process map 4](https://i.nostr.build/LeC1nGlfeW9L32O5.png)

### Define "Done"

Okay, this is where we start coding! Finally!!

![Woo Hoo](https://i.nostr.build/PnTTXgEY6x7zu9uz.png)

LOL, just kidding. I'm such a kidder.
Nah, this is where we figure out how to tell if we're finished working.

No, I'm done joking, now. I'm serious. Figuring out when you're actually finished is one of the most difficult tasks in computer science.

> There are only two hard things in Computer Science: 
> cache invalidation, naming things, and figuring out when you're done.
> 
> -- Silberengel

The key to knowing when you're done, once you're done, is defining what "done" will be, when you get there. Got that?

I'm just going to show and then tell, on this one, I think.

**I'll be done when...**

* my tests all run
* my tests are all green
* my software does what I wanted it to do

Okay, so, what do I want it to do? I mean, like, _in detail_ ?

### The Backlog

To help us figure out what we want, someone really clever invented something called _user stories_ and I'll be using those to define what the criteria are, for me to accept that the software is actually, really done.

Now, these criteria are not static. Rather, they're something roughly defined in the planning phase, and they get further-clarified, for each increment, as you go along. And new stories get added to your backlog, as you think them up.

Or something like that. You do you.

### Increment Goals

The first increment will be my MVP. Every increment should have a goal, that the selection of stories is helping you to achieve. Otherwise, the selection would be haphazard and you wouldn't know which stories to pull from the backlog.

My goal for the MVP increment is to publish this article to Nostr and follow that with publishing a kind 01 note, and then linking to the kind 01 note in njump.

I'm going to create a folder called `stories` and define, in greater -- but not exacting -- detail, what Sybil should do, to cover the MVP. At the end of the MVP development cycle, I will look at these stories, to see if Sybil "does what I want it to do".

Here is an example of such a story.

[Insert screen shot of gherkin scenario.]

### Step 3 completed: n? hours

[Insert text describing the phase experience.]

## Step 4: Development Phase

![my process map 4](https://i.nostr.build/AYe4tjLVLcnWaTdj.png)

Okay, you made it. Hurrah! Let the coding begin!

We're basically finished with all of the lead in and the rest, as we say, _is just doing_.

The rough outline of the coding tasks is:

1. pull a user story for this increment
2. flesh it out a bit, and refine it
3. write a test, to cover a step in the user story
4. run the test, to make sure it fails
5. write application code to pass the test
6. run the test, to make sure it passes
7. commit the change
8. pull the next user story... and so on, and so forth

Once of the preselected user stories are implemented and committed, we can begin building:

1. push your changes to Github
2. trigger the Jenkins pipeline (happens automaticaly, if you set it up right)
3. ask some dev frens to review your code
4. correct increment, as needed
5. push your changes and trigger the pipeline, again, if applicable

Now, do a bit of exploratory manual testing, just to make sure you didn't miss something really obvious.

Release the increment to the public, as version 0.0.1.

** AND YOU ARE DONE! **

It sounds worse, than it is. Actually pretty fun to do.

### Proof of Development

Here are some screen shots, so you can sort of see what this looks like. 

[Insert screen shots of MVP development here.]

If you want to watch this phase in action, starting with the MVP increment, just check out my Sybil project repo. I'm not going to blog about it because this article is already crazy-long.

### Anyways...

Generally, developers: 

* only do the research phase and just prototype all day, never reaching a production-ready increment,
* they start out in the development phase and sort of wander all over the place because they have no road map for what they want to build and no tools with which to build it, or
* they have a business analyst or project manager who does the project phase simultaneously to the beginning of the development phase, which is temporarily chaotic, but does actually work.

What I described here, in this loooonnnngggg article, is not an extraordinary amount of effort, but it makes a big difference, once you get to the development phase.
You can now just iterate, iterate, iterate..., while updating your environment (tests, automation scripts, etc.)

### Step 4 completed: ∞ hours

Step 4 is basically never completed. It just sort of peters out into a maintenance phase, where you just make tiny increments to fix bugs and manage library updates, or you just give up and move on with your life.

![The end](https://i.nostr.build/WiA8fmOgHJfkA3Od.jpg)