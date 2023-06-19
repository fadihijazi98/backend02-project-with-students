<?php

/*
         * 1.With the last code statement, if the handler was defined as private
         * recursion will occur because of calling __call method frequently
         * since handler is private ,and we can't access it from outside
         * class where it were defined, so we define all handlers as protected
         *
         * 2.The value of $method will be the value of custom handler if it's not
         * null,but if it's null,the value will be the value of current request method
         * then we will get the handler that associated with it
         *
         * 3.Remember that the used operation above is called ternary operation
         * which checks the value of a condition if it's true of false,
         * if it's true,compiler will execute code statement that is after the ?,
         * otherwise (the condition is false), code statement after : will be executed
         *
         * 4.Note that if the custom handler was null, the value of request method will still
         * the same and the value of $handler will be one of the 4 values registered in the
         * handlerMap array
 */
