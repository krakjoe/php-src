/* This is a generated file, edit the .stub.php file instead.
 * Stub hash: 850d7fab5cbed25733d32b5c9aa8107dda0c0b15 */

ZEND_BEGIN_ARG_INFO_EX(arginfo_class_Partial___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_Partial___invoke, 0, 0, IS_MIXED, 0)
	ZEND_ARG_VARIADIC_TYPE_INFO(0, args, IS_MIXED, 0)
ZEND_END_ARG_INFO()


ZEND_METHOD(Partial, __construct);
ZEND_METHOD(Partial, __invoke);


static const zend_function_entry class_Partial_methods[] = {
	ZEND_ME(Partial, __construct, arginfo_class_Partial___construct, ZEND_ACC_PRIVATE)
	ZEND_ME(Partial, __invoke, arginfo_class_Partial___invoke, ZEND_ACC_PUBLIC)
	ZEND_FE_END
};

static zend_class_entry *register_class_Partial(void)
{
	zend_class_entry ce, *class_entry;

	INIT_CLASS_ENTRY(ce, "Partial", class_Partial_methods);
	class_entry = zend_register_internal_class_ex(&ce, NULL);
	class_entry->ce_flags |= ZEND_ACC_FINAL;

	return class_entry;
}
