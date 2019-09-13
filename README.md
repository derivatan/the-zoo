# The Zoo
This is a game where the application tries to guess what animal you are thinking of by asking yes/no questions.
For each time application makes a incorrect guess of the animal it will add your animal to its database along with a question that separates that animal from its guess. 
So the database will expand as the game is played.

## Example gameplay
1. Does it have four legs -> yes
2. Is it a Dog -> No
3. Player wins, but is asked two questions:<br />
What was your animal? -> Cow<br />
Can you give me a question for which the answer for "Cow" is "yes" and the answer for "Dog" is "no". -> Does it give us milk?

Next time the game is played

1. Does it have four legs -> yes
2. Does it give us milk? -> yes
3. Is it a Cow? -> yes
4. Application wins.

## Notes
* Uses [Lumen](https://lumen.laravel.com/) framework
* Coding style is according to [PSR-2](https://www.php-fig.org/psr/psr-2/)

## Prerequisities
To run this application you need these programs on your machine.
* make
* docker
* docker-compose

## Running the application
1. `git clone https://github.com/derivatan/the-zoo.git` Download the code on your computer.
1. `cd the-zoo` Change directory to run further commands.
1. `make build` to build the docker image for future usage.
1. `make run` to start all containers needed to run the application.
1. `make run-migrate` to create the database. This can be skipped after the first run.   
1. Go to `http://localhost:8080` and enjoy.

step 3-5 can be run all at once with just `make`.

## Future ideas

* Add a winning counter on each animal in the database, to get a high-score of the top animals being thought of..
* Have multiple question-trees, and randomly pick one on start.
* Visualize the question-tree.
