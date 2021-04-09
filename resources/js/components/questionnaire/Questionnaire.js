import React, { useState} from 'react';
import ReactDOM from "react-dom";
import Icon from "@mdi/react";
import { mdiPlusCircle,mdiAccountCircle } from '@mdi/js';
import List from '@material-ui/core/List';


import PropTypes from 'prop-types';
import Groups from "./Groups/Groups";
import {GroupProvider} from "./Groups/GroupContext";
import GroupAddModal from "./Groups/GroupAddModal";
import {SectionProvider} from "./Sections/SectionContext";
import ListSections from "./Sections/ListSections";
import SectionAddModal from "./Sections/SectionAddModal";
import Sections from "./Sections/Sections";
import {QuestionProvider} from "./questions/QuestionContext";
import QuestionPanel from "./questions/QuestionPanel";
import Questions from "./questions/Questions";


const Questionnaire = ()  => {

    const [openGroupModal,setOpenGroupModal] = useState(false);
    const handleCloseGroupModal = ()=> setOpenGroupModal(false);
    const [openSectionAddForm,setOpenSectionAddForm] = useState(false);

    const handleCloseAddSectionForm = () =>  setOpenSectionAddForm(false);


    return (
        <div className="py-6">


            <div className="flex w-full min-w-full divide-y divide-gray-200">
                <div onClick={ () => setOpenGroupModal(true) } style={{ backgroundColor:'#e5f3fe', cursor:'pointer' }}   className="p-3 w-1/4 button font-bold" >
                    Groups <Icon path={mdiPlusCircle} size={1} color="#02497f" className="inline"/>
                </div>

                <div onClick={ () => setOpenSectionAddForm(true) } style={{ backgroundColor:'#ffdfe1bf',cursor:'pointer' }} className="p-3 w-1/4 font-bold">
                    Sections <Icon path={mdiPlusCircle} size={1} color="#d90804" className="inline"/>
                </div>

                <div style={{ backgroundColor:'#e6ffe9' }} className="p-3 w-1/2 font-bold text-right">
                    Questions <Icon path={mdiPlusCircle} size={1} color="#147959" className="inline"/>
                </div>
            </div>
            <GroupProvider>
                <SectionProvider>
                    <QuestionProvider>
                        <div className="flex w-full min-w-full divide-y divide-gray-200">
                            <GroupAddModal open={openGroupModal} handleClose={handleCloseGroupModal}/>
                            <SectionAddModal open={openSectionAddForm} handleClose={handleCloseAddSectionForm}/>
                            <Groups/>

                            <div className="p-3 w-1/4">
                                <Sections/>
                            </div>
                            <div className="p-3 w-1/2">
                                <Questions/>
                            </div>
                        </div>
                    </QuestionProvider>
                </SectionProvider>
            </GroupProvider>
        </div>
    );

}

Questionnaire.propTypes = {};

export default Questionnaire;
if (document.getElementById('questionnaire-component')) {
    ReactDOM.render(<Questionnaire />, document.getElementById('questionnaire-component'));
}
