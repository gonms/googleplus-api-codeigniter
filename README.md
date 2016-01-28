# GooglePlus Login API for CodeIgniter

This is a small example of how to integrate GooglePlus Login API in your CodeIgniter project.

### Create the project
First of all, you have to create a project in [Google Developers Console]
- Create the project
- Enable Google+ API
- In the left sidebar, select "Credentials"
  - Select OAuth Client ID from the New Credentials combo
  - Then select Web Application
  - Enter a name for that Client ID
  - Once you press the Create button, you will see your OAuth Client ID and Secret
  - You will have to write these values in the config/googleplus.php file

### Installation
Just copy all files into your CodeIgniter application folder

### Usage
Add the library in the config/autoload.php file and then use this in your controller:
```sh
$this->googleplus->login();
```

   [Google Developers Console]: <https://console.developers.google.com/start>
