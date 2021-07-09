Settings model for leadvertex plugins based on [leadvertex/plugin-component-db](https://github.com/leadvertex/plugin-component-db).

This model has special static method `Settings::addOnSaveHandler(callable $handler)` which can execute any passed callable
after settings was stored in database