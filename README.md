GateKeeperPropelBundle
======================

## Installation
#### Composer require
 - `"docplanner/gatekeeper-bundle": "dev-master"`
 - `"lbarulski/gatekeeper-propel-bundle": "dev-master"`

#### Register bundles
 - `new \GateKeeperBundle\GateKeeperBundle()`
 - `new lbarulski\GateKeeperPropelBundle\GateKeeperPropelBundle()`

#### Migrate database
 - `app/console propel:migration:generate-diff`
 - `app/console propel:migration:migrate`
