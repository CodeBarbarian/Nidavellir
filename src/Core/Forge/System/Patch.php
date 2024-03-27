<?php
/**
 * @name: Patch
 * @version: 1.0
 * @description: This class gives us the ability to quickly "patch" functions / methods without
 *               touching the original code of something.
 */
namespace Core\Forge\System;


/**
 * Idea time: So to be able to "patch" something without touching the original code, we are either talking
 * about injections, or a way to interrupt the normal behaviour. Or in some instances, maybe even an override?
 * So I need to figure out which approach I want to do here, and how it should work.
 *
 * Let us say we have a method in a class
 *
 *      public static function getData() <-- This method is what I want to override, so when the "system" asks
 * for the given method, I want to redirect it to my current one.
 *
 * I guess this needs to be either in the router or the controller. The router handles 99.9% of everything,
 * but the controller have the ability to use the "before" method, which allows me to perform anything before
 * the method is called.
 *
 * So if I understand correctly we could do the following.
 *
 * 1. Implement a way to "interrupt/inject" a "patch" into loop before the method is called, and simply ovverride it.
 * 2. Find a way so I only need to do this ones even for controller, and models.
 *
 *
 *
 * Syntax?
 *      PATCH::new(string $MethodName, function(){
 *          CODE TO PERFORM
 *      });
 *
 *
 * This might be possible if we make sure to do this in both the parent classes "Controller" and "Model".
 */
class Patch {
    public static function new(string $Method, object $Override) {

    }
}