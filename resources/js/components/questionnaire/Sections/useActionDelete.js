import React, {useContext} from 'react';
import PropTypes from 'prop-types';
import {SectionContext} from "./SectionContext";
import {apiDelete} from "../../utils/ConnectApi";


const UseActionDelete = () => {
    const [sections,setSections] = useContext(SectionContext);

    const handleDeleteModal = (section_id) => {
        apiDelete(`sections/${section_id}`).then(() =>{
            setSections(sections.filter((section) => section.id !== section_id));
        });
    }

    return {handleDeleteModal}
}

UseActionDelete.propTypes = {};

export default UseActionDelete;
