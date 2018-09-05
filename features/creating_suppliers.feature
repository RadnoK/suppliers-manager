@suppliers @application
Feature: Creating Suppliers
    In order to have supplier data in the system
    As an Administrator
    I want to create a new supplier with its details

    Scenario: Creating a supplier
        When I create a "First" supplier
        Then the "First" supplier should be in the system
