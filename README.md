[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fdarksworm%2Fopenchat_kata_inside_out%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/darksworm/openchat_kata_inside_out/master) [![Coverage Status](https://coveralls.io/repos/github/darksworm/openchat_kata_inside_out/badge.svg?branch=master)](https://coveralls.io/github/darksworm/openchat_kata_inside_out?branch=master)

Openchat API implemented using Inside-Out/Chicago style TDD with PHP8 and Laravel similarly as in the
[London vs. Chicago video series](https://cleancoders.com/series/comparativeDesign).

N.B. The react front-end does not work unmodified with this, you have to apply the `react_post_as_json.patch` patch to
it because laravel does not understand `application/x-www-form-urlencoded` apparently.

# Work In Progress
