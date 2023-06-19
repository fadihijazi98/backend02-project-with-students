<?php

// It will be the container for all routes that user will ask to get in

/** Documentation:
 * 1.This method is required to add `api/versionNumber` to all registered requests.
 * 2.Assure to pass an integer and none null value when you are using this method.
 * @param integer $versionNumber
 * @return int
 * @throws \Exception when $versionNumber is null or not integer
 */

/* Documentation:
         * This function is required because in future the structure of
         * routes array may be changed, so it will reduce positions of change
         * and it will be the reference for all routes
         */

/* Documentation:
         * 1.This function will register the requests that are manipulated
         * by GET method with the specified controller to handle it
         * 2.When we don't get a value of custom handler because we didn't register it
         * when we call the requests method in index.php, the default value (null)
         * will be its value,and this point is true for all other request methods
         * (POST,PUT,DELETE)
         */

/* Documentation:
         * This function will register the requests that are manipulated
         * by POST method with the specified controller to handle it
         */

/* Documentation:
         * This function will register the requests that are manipulated
         * by PUT method with the specified controller to handle it
         */

/* Documentation:
        * This function will register the requests that are manipulated
        * by DELETE method with the specified controller to handle it
        */

/* Documentation:
       * 1.This function will receive the full URL, so we wrote the cutting
       * algorithm to only get the signature of the API or request
       *
       * 2.This function will map between the request (path) and the required
       * controller to manage it so that client get the wanted results of the
       * wanted API,and also map path with its parameters
       */

/*
   * 1. The continue statement represents the skip step for {id} item
   * 2. The order of if statements is very important for the
   * skip step
   */

/**
 * We have to send $routes[$requestPath] because this path
 * may be associated with different request methods, so we have to
 * check the correct request method with the specified path
 */