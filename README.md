# create database


# php artisan migrate
# php artisan db:seed --class=RolesTableSeeder                    ( for admin role )









# register

# http://127.0.0.1:8000/api/auth/register                         (POST)
#
#   {
#       "name": "name",
#       "lastname": "lastname",
#       "image": "image name",                                    ( նկարն պահեք Ձեր մոտ թղթապանակում , անունն ուղարկեք )
#       "email": "email@gmail.com",
#       "password": "password",
#       "age": "25",
#       "gender": "male"
#   }

# success
# "message": "Register success"

# fali
# "message": "Not validate"













# login

# http://127.0.0.1:8000/api/auth/login                         (POST)
#
#   {
#    "email": "email@gmail.com",
#    "password": "123456789"
#   }

# success
# return data

# fali                                                         ( when login or password not correct )
# "message": "Error With Login"

# fali                                                         ( when user active is 0 )
# "message": "User is not active"











# get users with admin role

# http://127.0.0.1:8000/api/auth/users                         (POST)
#
#   {
#    "email": "email@gmail.com",
#   }

# success                                                      ( when role is admin )
# return data

# fali                                                         ( when email parameter is not correct )
# 'message' => 'This email does not exist'

# fali                                                         ( when role is not admin )
# "message": "User is not active"








# edit user active

# http://127.0.0.1:8000/api/auth/editUser                         (POST)
#
# {
#     "email" : "admin@gmail.com",
#     "active" : 1                                             ( 0 ( passive ) or 1 ( active ) )
# }

# success                                                      ( when role is admin )
# "message": "User updated"

# fali                                                         ( when email parameter is not correct )
# "message": "This email does not exist"

# fali                                                         ( when role is not admin )
# "message": "User is not active"