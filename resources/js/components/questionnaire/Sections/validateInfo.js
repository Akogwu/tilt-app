export default function validateInfo(values){
    const errors = {};

    if (!values.name.trim())
        errors.name = 'Section name is required';
    if (!values.group_id)
        errors.group_id = 'Group is required';
    if (!values.description.trim())
        errors.description = 'Section\'s description is required';

    return errors;
}
