/*
   +----------------------------------------------------------------------+
   | Zend Engine                                                          |
   +----------------------------------------------------------------------+
   | Copyright (c) Zend Technologies Ltd. (http://www.zend.com)           |
   +----------------------------------------------------------------------+
   | This source file is subject to version 2.00 of the Zend license,     |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.zend.com/license/2_00.txt.                                |
   | If you did not receive a copy of the Zend license and are unable to  |
   | obtain it through the world-wide-web, please send a note to          |
   | license@zend.com so we can mail you a copy immediately.              |
   +----------------------------------------------------------------------+
   | Authors: krakjoe <krakjoe@php.net>                                   |
   +----------------------------------------------------------------------+
*/
#ifndef ZEND_PARTIAL_H
#define ZEND_PARTIAL_H

extern zend_class_entry *zend_partial_ce;

void zend_register_partial_ce(void);

void zend_partial_apply(zval *res, zend_function *op_array, zend_class_entry *scope, zend_class_entry *called_scope, zval *this_ptr, zend_execute_data *call);
#endif
