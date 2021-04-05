export default function validateInfo(values){
    const errors = {};

    if (!values.name.trim())
        errors.name = 'Group name is required';
    if (!values.color.trim())
        errors.color = 'Color is required';
    if (!values.icon.trim())
        errors.icon = 'Group icon is required';

    return errors;
}
