intdoc
======

Interactive documentation for JavaScript

Extracts as much documentation information from an object as possible

The docstring is determined by looking at `.__doc__` and if that is
set, using that.
If that is not found, then `.constructor.__doc__` is examined, and if
that is not found, then the

If none of those are set, then in a function definition,
if the first token inside the function body is a string literal,
then that is the docstring; if the first token is anything else,
then the function is not considered to have a docstring.

