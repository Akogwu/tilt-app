export default function validateInfo(values){
    const errors = {};

    if (!values.question.trim())
        errors.question = 'Question is required';
    if (!values.section_id)
        errors.section_id = 'Section is required';

    return errors;
}
