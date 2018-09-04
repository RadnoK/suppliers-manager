Feature: Synchronizing Suppliers
    In order to have updated suppliers information
    As an Administrator
    I want to synchronize suppliers and their products in the system

    Scenario: Synchronizing first supplier
        When I synchronize "First" supplier information
        Then I should see a table with data
            | ID | Name | Desc |
