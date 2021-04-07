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
#include "zend.h"
#include "zend_API.h"
#include "zend_closures.h"
#include "zend_partial.h"
#include "zend_partial_arginfo.h"

zend_class_entry *zend_partial_ce;
zend_object_handlers zend_partial_handlers;

typedef struct _zend_partial {
    zend_object std;
    zval        closure;
    zval        inner;
    zval        This;
    zval        *argv;
    uint32_t     argc;
} zend_partial;

static zend_object* zend_partial_new(zend_class_entry *type) {
    zend_partial *partial = ecalloc(1, sizeof(zend_partial));
    
    zend_object_std_init(&partial->std, type);
    
    partial->std.handlers = &zend_partial_handlers;
    
    return (zend_object*) partial;
}

static HashTable *zend_partial_debug(zend_object *object, int *is_temp) {
    zend_partial *partial = (zend_partial*) object;
    zval args;
    HashTable *ht;
    
    *is_temp = 1;
    
    ht = zend_new_array(2);
    
    zend_hash_update(
        ht, ZSTR_KNOWN(ZEND_STR_FUNCTION), &partial->closure);
    Z_ADDREF(partial->closure);
    
    array_init(&args);
    zend_hash_update(ht, ZSTR_KNOWN(ZEND_STR_ARGS), &args);
    
    zval *arg = partial->argv,
         *end = arg + partial->argc;
    uint32_t idx = 0;
    
    while (arg < end) {
        if (Z_TYPE_P(arg) == IS_UNDEF) {
            zend_hash_index_add_empty_element(Z_ARRVAL(args), idx);
        } else {
            zend_hash_index_add(Z_ARRVAL(args), idx, arg);
            
            if (Z_OPT_REFCOUNTED_P(arg)) {
                Z_ADDREF_P(arg);
            }
        }
        idx++;
        arg++;
    }
    
    return ht;
}

static void zend_partial_free(zend_object *object) {
    zend_partial *partial = (zend_partial*) object;
    
    zend_object_std_dtor(object);
    
    if (Z_TYPE(partial->inner) == IS_OBJECT) {
        zval_ptr_dtor(&partial->inner);
    } else if (Z_TYPE(partial->This) == IS_OBJECT) {
        zval_ptr_dtor(&partial->This);
    }
    zval_ptr_dtor(&partial->closure);

    zval *arg = partial->argv,
         *end = arg + partial->argc;
         
    while (arg < end) {
        if (Z_OPT_REFCOUNTED_P(arg)) {
            zval_ptr_dtor(arg);
        }
        arg++;
    }
    
    efree_size(partial->argv, sizeof(zval) * partial->argc);
}

void zend_register_partial_ce(void) {
    zend_partial_ce = register_class_Partial();
    
    zend_partial_ce->create_object = zend_partial_new;
    
    memcpy(&zend_partial_handlers, 
            &std_object_handlers, sizeof(zend_object_handlers));
    
    zend_partial_handlers.free_obj = zend_partial_free;
    zend_partial_handlers.get_debug_info = zend_partial_debug;
}

ZEND_METHOD(Partial, __invoke)
{
    zend_partial *partial = (zend_partial*) Z_OBJ_P(ZEND_THIS);
	zval *args;
	uint32_t num_args;
	HashTable *named_args;

	ZEND_PARSE_PARAMETERS_START(0, -1)
		Z_PARAM_VARIADIC_WITH_NAMED(args, num_args, named_args)
	ZEND_PARSE_PARAMETERS_END();
	
	zval *heap = emalloc(sizeof(zval) * partial->argc),
	     *arg = heap,
	     *end = heap + partial->argc;

    /* TODO: make this nice, push a frame, flag it for cleanup
             remove fcf from end of apply */
    memcpy(heap, partial->argv, sizeof(zval) * partial->argc);
    
	while (arg < end) {
	    if (Z_TYPE_P(arg) == IS_UNDEF) {
	        ZVAL_COPY_VALUE(arg, args);
	        args++;
	    }
	    
	    arg++;
	}

	call_user_function_named(
        CG(function_table), NULL,
        &partial->closure,
        return_value,
        partial->argc,
        heap, named_args);

    efree_size(heap, sizeof(zval) * partial->argc);
}

/* {{{ Private constructor preventing instantiation */
ZEND_COLD ZEND_METHOD(Partial, __construct)
{
	zend_throw_error(NULL, "Instantiation of class Partial is not allowed");
}
/* }}} */

void zend_partial_apply(zval *res, zend_function *op_array, zend_class_entry *scope, zend_class_entry *called_scope, zval *this_ptr, zend_execute_data *call) {
    object_init_ex(res, zend_partial_ce);

    zend_partial *partial = (zend_partial*) Z_OBJ_P(res);
    
    zend_create_closure(
        &partial->closure, op_array, scope, called_scope, this_ptr);
    
    zval *arg = ZEND_CALL_ARG(call, 1),
         *end = arg + ZEND_CALL_NUM_ARGS(call);
    
    partial->argc = ZEND_CALL_NUM_ARGS(call);
    partial->argv = emalloc(sizeof(zval) * partial->argc);

    memcpy(partial->argv, arg, partial->argc * sizeof(zval));
    
    while (arg < end) {
        if (Z_OPT_REFCOUNTED_P(arg)) {
            Z_ADDREF_P(arg);
        }
        arg++;
    }
    
    if (ZEND_CALL_INFO(call) & ZEND_CALL_CLOSURE) {
        ZVAL_OBJ(&partial->inner, ZEND_CLOSURE_OBJECT(call->func));
    } else if (ZEND_CALL_INFO(call) & ZEND_CALL_RELEASE_THIS) {
        ZVAL_COPY_VALUE(&partial->This, &call->This);
    }
    
    zend_vm_stack_free_call_frame(call);
}
