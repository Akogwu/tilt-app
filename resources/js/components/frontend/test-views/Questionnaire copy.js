import React, { Component } from "react";
import { Button, Spinner } from "react-bootstrap";
import { Stepper, Step, StepLabel } from "@material-ui/core";
import questions from "./data/questions";
import QuestionGroupSection from "./view-sections/QuestionGroupSection";
import PageHeadingSection from "../../components/sections/PageHeadingSection";
import Section from "./view-sections/Section";
import ProgressBar from "./view-sections/ProgressBar";
import QuestionItem from "./view-sections/QuestionItem";
import PageHeadingButton from "../../components/snippets/PageHeadingButton";
import PageButtonIconRight from "../../components/snippets/PageButtonIconRight";
import PageButtonIconLeft from "../../components/snippets/PageButtonIconLeft";
import axios from "axios";
import config from "../../../helpers/Config";
import AlertMessage from "../../Alert";
const Helpers = require("../../../helpers/Helpers");

class Questionnaire extends Component {
	state = {
		questionGroups: null,
		activeGroup: { name: null, index: 0 },
		activeColor: null,
		completedGroups: [],
		activeSection: { name: null, index: 0 },
		sections: [],
		loading: false,
		completedQuestions: [],
		progress: 0,
		activeQuestions: [],
		allquestions: [],
		actvQuest: [],
		complete: false,
		sloading: false,
		completeSecQuestions: false,
		openMessage: false,
		message: "",
		severity: "",
	};

	setOpentMessage = ($severity, $message) => {
		this.setState({
			message: $message,
			openMessage: true,
			severity: $severity,
		});
	};

	closeMessage = () => {
		this.setState({ openMessage: false });
	};
	async componentDidMount() {
		await this.getQuestns();
		this.setState({
			questionGroups: this.getQuestionGroupNames(),
			activeGroup: { name: this.getQuestionGroupNames()[0], index: 0 },
			activeColor: this.getQuestionGroupNames()[0].color,
			sections: this.initialSections(),
			activeSection: {
				name: this.initialSections()[0] && this.initialSections()[0],
				index: 0,
				questions:
					this.initialSections()[0] && this.initialSections()[0].questions,
			},
			activeQuestions: this.getNewQuestions(
				this.getQuestionGroupNames()[0],
				this.initialSections()[0]
			),
		});
	}

	async getQuestns() {
		await axios
			.get(config.apiBaseUrl + "/test/get-questions")
			.then((res) => {
				if (res.status) {
					this.setState({ loading: false });
					this.setState({ allquestions: res.data });
				} else {
					this.setState({ loading: false });
					alert("Could not retrieve questions, Please reload");
				}
			})
			.catch((err) => {
				this.setState({ loading: false });
				console.log(err);
				alert("Error loading questions");
			});
	}

	initialSections = () => {
		return this.getSectionsArray(this.getQuestionGroupNames()[0]);
	};

	getAllQuestionsCount() {
		let questionsCount = 0;
		this.getQuestionGroupNames().forEach((group) => {
			let sections = this.getSections(group);
			sections.forEach((section) => {
				questionsCount += section.questions.length;
			});
			// for (let section in sections) {
			//     console.log(Object.keys(section).length);
			//
			//     if (sections.hasOwnProperty(section)) {
			//             questionsCount++;
			//         }
			// }
		});
		return questionsCount;
	}

	updateCompletedQuestions = (questionID, answer) => {
		const completedQuestions = this.state.completedQuestions.filter(
			(question, index) => question.questionnaire_id !== questionID
		);
		completedQuestions.push({
			questionnaire_id: questionID,
			weight_point_id: answer,
		});
		this.setState({ completedQuestions: completedQuestions });
	};

	setProgress() {
		const totalAnswered = this.state.completedQuestions.length;
		const totalQuestions = this.getAllQuestionsCount();
		const progress = (totalAnswered / totalQuestions) * 100;
		this.setState({ progress: Math.round(progress) });
	}

	setActiveSection(activeGroupName, newActiveSectionName, currIndex) {
		let newSectionIndex = 0;

		if (newSectionIndex < this.getSections(activeGroupName).length - 1) {
			newSectionIndex = this.state.activeSection.index + 1;
		}
		if (currIndex === 0) {
			newSectionIndex = currIndex;
		}
		const sectQuestions = this.getSections(activeGroupName)[newSectionIndex]
			.questions;
		this.setState({
			activeSection: {
				name: this.getSections(activeGroupName)[newSectionIndex],
				index: newSectionIndex,
			},
		});
	}

	setPrevActiveSection(activeGroupName, newActiveSectionName, currIndex) {
		let newSectionIndex = 0;

		if (newSectionIndex < this.getSections(activeGroupName).length - 1) {
			newSectionIndex = this.state.activeSection.index - 1;
		}
		if (currIndex === 0) {
			newSectionIndex = currIndex;
		}
		const sectQuestions = this.getSections(activeGroupName)[newSectionIndex]
			.questions;
		this.setState({
			activeSection: {
				name: this.getSections(activeGroupName)[newSectionIndex],
				index: newSectionIndex,
			},
		});
	}


	// setActiveSection(activeGroupName, newActiveSectionName, newIndex) {
	// 	let newSectionIndex = 0;

	// 	newSectionIndex = newIndex;

	// 	if(newIndex === 0){
	// 		newSectionIndex = newIndex;
	// 	}

	// 	const sectQuestions = this.getSections(activeGroupName)[newSectionIndex]
	// 		.questions;
	// 	this.setState({
	// 		activeSection: {
	// 			name: this.getSections(activeGroupName)[newSectionIndex],
	// 			index: newSectionIndex,
	// 		},
	// 	});
	// }

	setActiveGroup(activeGroupName, newIndex) {
		this.setState({
			activeGroup: {
				name: activeGroupName,
				index: newIndex,
			},
			activeColor: this.getQuestionGroup(newIndex).color,
		});
	}

	setNewSections(activeGroup) {
		this.setState({
			sections: this.getSections(activeGroup),
		});
	}

	setActiveQuestions(activeGroupName, activeSectionName) {
		this.setState({
			activeQuestions: this.getNewQuestions(activeGroupName, activeSectionName),
		});
	}

	getNewQuestions(activeGroupName, activeSectionName) {
		if (activeSectionName) {
			return activeSectionName.questions;
		}
	}

	getAllQuestions() {
		return this.state.allquestions;
	}

	getQuestionGroup(questionGroupName) {
		return this.getAllQuestions()[questionGroupName];
	}

	getQuestionGroupNames() {
		return this.getAllQuestions();
	}

	getSections(questionGroupName) {
		return questionGroupName.sections;
	}

	getSectionsArray(questionGroup) {
		return this.getSections(questionGroup);
	}

	buttonGroupColor = (questionGroup) => {
		if (this.state.activeGroup) {
			if (this.state.activeGroup.name === questionGroup.name) {
				return questionGroup.color;
			}
		}
		return "gray-300";
	};

	submitQuestions = async (e) => {
		e.preventDefault();
		this.setState({ sloading: true });
		localStorage.removeItem("@detailedResults");
		if (this.state.completedQuestions.length === 0) {
			return alert("You did not answer any Questionnaire");
		}
		if (this.state.progress !== 100) {
			this.setOpentMessage("error", "Seems you did not answer all questions.");
			this.setState({ sloading: false });
			return;
		}

		let testSession = {};
		testSession.session_id = localStorage.getItem("@TstS3ssion");
		testSession.questionnaire = this.state.completedQuestions;

		await axios
			.post(config.apiBaseUrl + "test/submit", testSession)
			.then((res) => {
				if (res.status) {
					this.setState({ sloading: false });
					this.props.history.replace("/test/summary-result", {
						sessionId: testSession.session_id,
					});
				} else {
					this.setState({ loading: false });
					alert("Could not submit test, Please reload");
				}
			})
			.catch((err) => {
				this.setState({ sloading: false });
				// console.log(err);
				alert("Error submitting Test");
			});
	};

	// handleNext = async (e) => {
	// 	e.preventDefault();
	// 	this.setState({ completeSecQuestions: false });
	// 	const group_id = document.getElementById("group_id");
	// 	group_id.scrollIntoView(
	// 		{
	// 			behavior: "smooth",
	// 		},
	// 		500
	// 	);

	// 	let activeGroupName = this.state.activeGroup.name;

	// 	if (
	// 		this.state.activeGroup.index ===
	// 		this.getQuestionGroupNames().length - 1
	// 	) {
	// 		if (
	// 			this.state.activeSection.index ===
	// 			this.getSections(activeGroupName).length - 2
	// 		) {
	// 			this.setState({ complete: true });
	// 		}
	// 	}

	// 	let activeSection = this.getSections(activeGroupName)[
	// 		this.state.activeSection.index + 1
	// 	];
	// 	if (
	// 		this.state.activeSection.index <
	// 		this.getSections(activeGroupName).length - 1
	// 	) {
	// 		this.setActiveSection(
	// 			activeGroupName,
	// 			activeSection,
	// 			this.state.activeSection.index + 1
	// 		);
	// 		this.setActiveQuestions(activeGroupName, activeSection);
	// 	} else {

	// 		const currentCompletedGroups = this.state.completedGroups;
	// 		currentCompletedGroups.push(activeGroupName);
	// 		this.setState({
	// 			completedGroups: currentCompletedGroups,
	// 		});
	// 		const currIndex = 0;
	// 		activeGroupName = this.getQuestionGroupNames()[
	// 			this.state.activeGroup.index + 1
	// 		];
	// 		this.setState({ activeGroup: { index: this.state.activeGroup.index } });
	// 		this.setActiveGroup(activeGroupName, currIndex);
	// 		activeSection = this.getSections(activeGroupName)[
	// 			this.state.activeSection.index
	// 		];

	// 		//this.setActiveSection(activeGroupName, activeSection, currIndex);
	// 		//this.setActiveQuestions(activeGroupName, activeSection);

	// 		this.setActiveSection(
	// 			activeGroupName,
	// 			activeSection,
	// 			this.state.activeSection.index + 1
	// 		);
	// 		this.setActiveQuestions(activeGroupName, activeSection);
	// 	}
	// };

	handleNext = async (e) => {
		e.preventDefault();
		this.setState({ completeSecQuestions: false });
		const group_id = document.getElementById("group_id");
		group_id.scrollIntoView(
			{
				behavior: "smooth",
			},
			500
		);

		let activeGroupName = this.state.activeGroup.name;

		if (
			this.state.activeGroup.index ===
			this.getQuestionGroupNames().length - 1
		) {
			if (
				this.state.activeSection.index ===
				this.getSections(activeGroupName).length - 2
			) {
				this.setState({ complete: true });
			}
		}

		let activeSection = this.getSections(activeGroupName)[
			this.state.activeSection.index + 1
		];
		if (
			this.state.activeSection.index <
			this.getSections(activeGroupName).length - 1
		) {
			this.setActiveSection(activeGroupName, activeSection);
			this.setActiveQuestions(activeGroupName, activeSection);
		} else {
			const currentCompletedGroups = this.state.completedGroups;
			currentCompletedGroups.push(activeGroupName);
			this.setState({
				completedGroups: currentCompletedGroups,
			});
			const currIndex = 0;
			activeGroupName = this.getQuestionGroupNames()[
				this.state.activeGroup.index + 1
			];
			this.setState({ activeGroup: { index: this.state.activeGroup.index } });
			this.setActiveGroup(activeGroupName, currIndex);
			activeSection = this.getSections(activeGroupName)[
				this.state.activeSection.index + 1
			];

			this.setActiveSection(activeGroupName, activeSection, currIndex);
			this.setActiveQuestions(activeGroupName, activeSection);
		}
	};

	//handles previous button click
	handlePrevious = async (e) => {
		e.preventDefault();
		this.setState({ completeSecQuestions: false });
		const group_id = document.getElementById("group_id");
		group_id.scrollIntoView(
			{
				behavior: "smooth",
			},
			500
		);

		let activeGroupName = this.state.activeGroup.name;

		//gets if last group
		// if (
		// 	this.state.activeGroup.index ===
		// 	this.getQuestionGroupNames().length - 1
		// ) {
		//gets if last section of last group
		// 	if (
		// 		this.state.activeSection.index ===
		// 		this.getSections(activeGroupName).length - 2
		// 	) {
		// 		this.setState({ complete: true });
		// 	}
		// }

		//gets previous action section
		let prevActiveSection = this.getSections(activeGroupName)[
			this.state.activeSection.index - 1
		];
		if (this.state.activeSection.index > 0) {
			this.setPrevActiveSection(
				activeGroupName,
				prevActiveSection,
				this.state.activeSection.index - 1
			);
			this.setActiveQuestions(activeGroupName, prevActiveSection);
		} else {
			// const currentCompletedGroups = this.state.completedGroups;
			// currentCompletedGroups.push(activeGroupName);
			// this.setState({
			// 	completedGroups: currentCompletedGroups,
			// });
			const newIndex = 0;
			activeGroupName = this.getQuestionGroupNames()[
				this.state.activeGroup.index 
			];
			this.setState({
				activeGroup: { index: this.state.activeGroup.index - 1 },
			});
			this.setActiveGroup(activeGroupName, this.state.activeGroup.index - 1);
			prevActiveSection = this.getSections(activeGroupName)[
			 	this.state.activeSection.index - 1
			];

			this.setPrevActiveSection(
				activeGroupName,
				prevActiveSection,
				this.state.activeSection.index - 1
			);
			this.setActiveQuestions(activeGroupName, prevActiveSection);
		}
	};

	handleAnswer = async (questionID, answer) => {
		await this.updateCompletedQuestions(questionID, answer);
		this.setProgress();
		let answered = this.state.completedQuestions;
		let activeGroupName = this.state.activeGroup.name;
		//const sectQuestions = this.getSections(activeGroupName)[0].questions;
		const sectQuestions = this.state.activeSection.name.questions;

		let checker = (arr, target) => target.every((v) => arr.includes(v));
		
		if (
			checker(
				answered.map((a) => a.questionnaire_id),
				sectQuestions.map((b) => b.questionnaire_id)
			)
		) {
			this.setState({ completeSecQuestions: true });
		}
	};

	renderQuestionGroups = () => {
		const questionGroups = this.state.questionGroups;
		return questionGroups.map((group, index) => {
			return (
				<Button key={index} variant={this.buttonGroupColor(group)}>
					<span>
						<i className={`fa fa-3x fa-${group.icon} pl-2 pr-2`}> </i>
					</span>
					{group.name.toUpperCase()}
				</Button>
			);
		});
	};

	renderSections = () => {
		const grpSect = this.state.activeGroup.name;
		if (grpSect != null) {
			return grpSect.sections.length >= 1 ? (
				grpSect.sections.map((section, index) => (
					<Step key={section + index}>
						<StepLabel>{Helpers.titleCase(section.name)}</StepLabel>
					</Step>
				))
			) : (
				<span
					style={{
						fontSize: 20,
						fontWeight: "700",
						color: "grey",
						justifySelf: "center",
					}}
				>
					No Section for this Group
				</span>
			);
		} else
			return (
				<span
					style={{
						fontSize: 20,
						fontWeight: "700",
						color: "grey",
						justifySelf: "center",
					}}
				>
					No Section for this Group
				</span>
			);
	};

	renderQuestions = () => {
		const activeGroupName = this.state.activeGroup.name;
		const activeSectionName = this.state.activeSection.name;

		if (activeSectionName != undefined && activeSectionName != null) {
			if (activeGroupName && activeSectionName.questions.length >= 1) {
				const activeQuestion = this.state.activeSection.name.questions;
				// this.getNewQuestions(activeGroupName, activeSectionName);
				if (this.state.activeColor === "") {
					this.setState({ activeColor: "primary" });
				}
				return activeQuestion.map((questionObject, index) => (
					<QuestionItem
						key={index}
						question={questionObject.question}
						weight_points={questionObject.weight_points}
						color={this.state.activeColor}
						onAnswer={(value) =>
							this.handleAnswer(questionObject.questionnaire_id, value)
						}
					/>
				));
			} else {
				return (
					<span
						style={{
							fontSize: 20,
							fontWeight: "700",
							color: "grey",
							marginLeft: 20,
							justifySelf: "center",
						}}
					>
						No Questions in this section
					</span>
				);
			}
		} else {
			return (
				<span
					style={{
						fontSize: 20,
						fontWeight: "700",
						color: "grey",
						marginLeft: 20,
						justifySelf: "center",
					}}
				>
					No Questions in this section
				</span>
			);
		}
	};

	showSpinner = (size = "lg", color = "primary") => (
		<Spinner animation="grow" size={size} aria-hidden="true" variant={color} />
	);

	render() {
		return (
			<main>
				<PageHeadingSection
					pageTitle={"TILT TEST"}
					pageTitleColor={"gray"}
					pt={0}
					pb={7}
				>
					<div className="alert alert-tertiary">
						<h4 className="text-bold text-white m-0">
							Please answer every question honestly
						</h4>
					</div>
				</PageHeadingSection>

				<QuestionGroupSection>
					{this.state.questionGroups
						? this.renderQuestionGroups()
						: this.showSpinner("lg")}
				</QuestionGroupSection>

				<ProgressBar
					progress={this.state.progress}
					color={this.state.activeColor}
				/>

				<Section>
					<div className="w-100">
						<Stepper
							activeStep={
								this.state.activeSection && this.state.activeSection.index
							}
							alternativeLabel
						>
							{this.renderSections()}
						</Stepper>
					</div>
				</Section>

				{this.state.loading ? (
					this.showSpinner("lg")
				) : (
					<div className="mb-10 mt-5">
						<AlertMessage
							open={this.state.openMessage}
							message={this.state.message}
							closeMessage={this.closeMessage}
							severity={this.state.severity}
						/>
						<Section>
							{this.renderQuestions()}
							<div className="container d-flex justify-content-center">
								{this.state.sloading ? (
									this.showSpinner("lg")
								) : (
									<span>
										{this.state.complete ? (
											<PageHeadingButton
												icon={"fa-send"}
												text={"Submit"}
												color={this.state.activeColor || "gray"}
												onClick={(e) => this.submitQuestions(e)}
											/>
										) : this.state.completeSecQuestions ? (
											<>
												{/* renders previous button */}
												<PageButtonIconLeft
													icon={"fa-arrow-left"}
													text={"Previous"}
													color={this.state.activeColor || "gray"}
													onClick={(e) => this.handlePrevious(e)}
												/>

												{/* renders next button */}
												<PageButtonIconRight
													icon={"fa-arrow-right"}
													text={"Next"}
													color={this.state.activeColor || "gray"}
													onClick={(e) => this.handleNext(e)}
												/>
											</>
										) : (
											<>
												<PageButtonIconLeft
													icon={"fa-arrow-left"}
													text={"Previous"}
													color={this.state.activeColor || "gray"}
													onClick={(e) =>
														this.setOpentMessage(
															"warning",
															"Please answer all questions in this section"
														)
													}
												/>

												<PageButtonIconRight
													icon={"fa-arrow-right"}
													text={"Next"}
													color={this.state.activeColor || "gray"}
													onClick={(e) =>
														this.setOpentMessage(
															"warning",
															"Please answer all questions in this section"
														)
													}
												/>
											</>
										)}
									</span>
								)}
							</div>
						</Section>
					</div>
				)}

				{/* 
                
                {this.state.loading ? this.showSpinner("lg") :
                <div className="mb-10 mt-5">
                    <AlertMessage  open={this.state.openMessage} message={this.state.message} closeMessage={this.closeMessage} severity={this.state.severity}/>
                    <Section>
                        {this.renderQuestions()}
                        <div className="container d-flex justify-content-center">
                        {this.state.sloading ? this.showSpinner("lg") : <span>
                            {this.state.complete ?
                                <PageHeadingButton
                                    icon={"fa-send"}
                                    text={"Submit"}
                                    color={this.state.activeColor || 'gray'}
                                    onClick={(e) => this.submitQuestions(e)}
                                />:
                                (this.state.completeSecQuestions)?
                                    <PageHeadingButton
                                    icon={"fa-arrow-right"}
                                    text={"Next"}
                                    color={this.state.activeColor || 'gray'}
                                    onClick={(e) => this.handleNext(e)}
                                    />:
                                    <PageHeadingButton
                                    icon={"fa-arrow-right"}
                                    text={"Next"}
                                    color={this.state.activeColor || 'gray'}
                                    onClick={(e) => this.setOpentMessage('warning','Please answer all questions in this section')}
                                    />}
                        </span> }
                        </div> */}
				{/* <div className="container d-flex justify-content-center mt-8">
                            <Link to={"/test/summary-result"} className={"lead"}>Get Result</Link>
                        </div> */}
				{/* </Section>
                </div>} */}
			</main>
		);
	}
}

export default Questionnaire;
