{
  isArray
  isFunction
  isNull
  isUndefined
  } = require 'lodash-node'
esprima = require 'esprima-fb'

endsWith = (str, suffix) ->
  """Checks whether a given string ends with `suffix`"""

  str.indexOf(suffix, str.length - suffix.length) isnt -1

startsWith = (str, prefix) ->
  """Checks whether a given string starts with `prefix`"""

  str[...prefix.length] == prefix


doc = (val) ->
  """Extracts as much documentation information from an object as possible

    The docstring is determined by looking at `.__doc__` and if that is
    set, using that.
    If that is not found, then `.constructor.__doc__` is examined, and if
    that is not found, then the

    If none of those are set, then in a function definition,
    if the first token inside the function body is a string literal,
    then that is the docstring; if the first token is anything else,
    then the function is not considered to have a docstring.

    """

  if isUndefined val
    return { type: 'Undefined' }
  if isNull val
    return { type: 'Null' }

  isNative = false
  isFibrous = false
  isCoWrapped = false
  actualVal = undefined
  ty = typeof val
  if ty?
    ty = ty.charAt(0).toUpperCase() + ty.slice(1)

  docString = null
  if val.__doc__?
      docString = val.__doc__.toString()
    else
      if val.constructor? and val.constructor.__doc__?
        docString = val.constructor.__doc__.toString()

  #if typeof val is 'function'
  if isFunction val
    # We need to wrap the function definition in parens so that the parser
    # treats it as an expression rather than a named function def
    if isFunction val.__fibrousFn__
      ty = 'fibrous Function'
      actualVal = val
      val = val.__fibrousFn__
      isFibrous = true
    else if isFunction val.__generatorFunction__
      ty = 'co.wrap Function'
      actualVal = val
      val = val.__generatorFunction__
      isCoWrapped = true
    else if isFunction val.___instapromiseOriginalFunction___
      ty = 'instapromise Function'
      actualVal = val
      val = val.___instapromiseOriginalFunction___
      isInstapromise = true

    s = val.toString()
    if endsWith s, ") { [native code] }"
      isNative = true
      docString = "[native code]"
      s = s.replace "[native code]", ""

    if startsWith s, "function*"
      isFunctionStar = true
      ty = 'Function*'

    parseTree = esprima.parse "(#{ s })"

    # Extract the list of named parameters
    params = (x.name for x in parseTree.body[0].expression.params)

    functionBodyParseTree = parseTree.body[0].expression.body.body

    if not docString?
      # Use the first expression in the function body iff it is
      # a string literal; or else, there is no doc string for this function
      if functionBodyParseTree.length
        first = functionBodyParseTree[0]
        if first.type == 'ExpressionStatement' and first.expression.type == 'Literal'
          docString = first.expression.value

  name = val.name ? val.__name__ ? null

  if isArray val
    ty = 'Array'

  info = { params: params, doc: docString, name: name, type: ty }

  if isNative
    info.nativeCode = isNative

  if isFibrous
    info.isFibrous = isFibrous

  if isFunctionStar
    info.isFunctionStar = isFunctionStar

  if isCoWrapped
    info.isCoWrapped = isCoWrapped

  if isInstapromise
    info.isInstapromise = isInstapromise

  if isFunction val
    info.code = val.toString()

  if actualVal?
    info.actualVal = actualVal

  info

module.exports = doc
