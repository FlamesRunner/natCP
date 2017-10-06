class ParentCls
  @__doc__: """Docstring for ParentCls @__doc__"""
  __doc__: """Docstring for ParentCls __doc__"""

  constructor: () ->
    """Docstring for ParentCls constructor"""
    return null

class ChildCls extends ParentCls
  @__doc__: """Docstring for ChildCls @__doc__"""
  __doc__: """Docstring for ChildCls __doc__"""

  constructor: () ->
    """Docstring for ChildCls constructor"""
    return null

class Child2 extends ParentCls

class Parent3
  @__doc__: "Only @doc here"

class Child3 extends Parent3
  constructor: () ->
    "docstring for child3 constructor"

module.exports = 
  ParentCls: ParentCls
  ChildCls: ChildCls
  Child2: Child2
  Parent3: Parent3
  Child3: Child3
