# Hotel Reservation Algorithm

In this project, the aim is to develop an algorithm that determines suitable rooms for reservation requests made in different periods at a 10-room hotel. Reservation requests are managed based on factors such as the number of people, period, gender, and bed type. The algorithm evaluates the given parameters to decide whether the reservation request can be matched with available rooms, and if so, which rooms can be selected. This algorithm will be designed and coded to interact with the user, prompting them for inputs like the number of people, period, gender, and bed type, and subsequently providing a decision on suitable room options.

## Run it on your computer

Clone the project
- This project has been executed on Sail. Run the project using the Ubuntu operating system.
- You can refer to the following link for more information: https://laravel.com/docs/10.x/sail

```bash
git clone https://github.com/nasuhyc/RoomSync.git
```
```bash
cd RoomSync
```
Install required packages

```bash
composer update
```

```bash
./vendor/bin/sail up
```

### Configuring A Shell Alias

#### Bash | Zsh

- If you are using Bash

```bash
echo "alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'" >> ~/.bashrc
```
```bash
source ~/.bashrc
```


- If you are using Zsh

```bash
echo "alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'" >> ~/.zshrc
```
```bash
source ~/.zshrc
```

### Run
```bash
sail up
```


#### `.env`
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=*
DB_USERNAME=root
DB_PASSWORD=

```


```bash
  sail artisan migrate:fresh --seed
```


## Information

The current project's routing structure is functioning within the web.php file. You can access it through the following link: http://localhost/getReservation.

Furthermore, the project has been tested as a REST API using Postman. To do this, you can modify and test the code within the commented section of the api.php file. 
Please remember to run "sail artisan route:cache" after removing the commented lines in api.php :)

Usage of the REST API:

Endpoint: http://localhost:80/api/make-reservation

Request Body:
```http
{
    "guestCount": 2,
    "start_date":"2023-08-07",
    "end_date":"2023-08-12",
    "gender":{
        "0":"male",
        "1":"female"
    },
    "type":"double"
}
```
