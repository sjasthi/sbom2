import React from 'react'
import { Row, Col, Label } from 'reactstrap'
import ContentPickerWidget from 'botpress/content-picker'
import SelectActionDropdown from 'botpress/select-action-dropdown'
import Select from 'react-select'
import style from './style.scss'
import { Alert } from 'react-bootstrap'
import { BotpressTooltip } from 'botpress/tooltip'
import { NumericInput } from '@blueprintjs/core'
import _ from 'lodash'

const MAX_RETRIES = 10
const DEFAULT_RETRY_ATTEMPTS = 3
const DEFAULT_TURN_EXP = -1

export class Slot extends React.Component {
  state = {
    selectedActionOption: undefined,
    selectedIntentOption: undefined,
    selectedSlotOption: undefined,
    contentElement: undefined,
    notFoundElement: undefined,
    intents: [],
    actions: [],
    maxRetryAttempts: DEFAULT_RETRY_ATTEMPTS,
    error: undefined,
    errorField: undefined,
    turnExpiry: DEFAULT_TURN_EXP
  }

  componentDidMount() {
    this.fetchActions()
    this.fetchIntents().then(() => this.setStateFromProps())
  }

  setStateFromProps = () => {
    const data = this.props.initialData

    if (data) {
      const turnExpiry = this.isTurnExpiryValid(data.turnExpiry) ? data.turnExpiry : DEFAULT_TURN_EXP
      const maxRetryAttempts = this.isRetryAttemptsValid(data.retryAttempts)
        ? data.retryAttempts
        : DEFAULT_RETRY_ATTEMPTS

      this.validateIntentExists(data.intent)
      this.validateSlotExists(data.intent, data.slotName)

      this.setState({
        selectedSlotOption: { value: data.slotName, label: data.slotName },
        selectedIntentOption: { value: data.intent, label: data.intent },
        selectedActionOption: data.validationAction && { value: data.validationAction, label: data.validationAction },
        contentElement: data.contentElement,
        notFoundElement: data.notFoundElement,
        maxRetryAttempts,
        turnExpiry
      })
    }
  }

  componentDidUpdate() {
    const { onValidChanged, onDataChanged } = this.props
    if (!this.isFormValid()) {
      return onValidChanged && onValidChanged(false)
    }

    const intent = this.getSelectedIntent()
    const slot = this.getSelectedSlot(intent)

    const data = {
      retryAttempts: this.state.maxRetryAttempts,
      contentElement: this.state.contentElement,
      notFoundElement: this.state.notFoundElement,
      turnExpiry: this.state.turnExpiry,
      validationAction: this.state.selectedActionOption && this.state.selectedActionOption.value,
      intent: intent && intent.name,
      slotName: slot && slot.name,
      entities: slot && slot.entities
    }

    onDataChanged && onDataChanged(data)
    onValidChanged && onValidChanged(true)
  }

  fetchIntents = () => {
    return this.props.bp.axios.get('/nlu/intents').then(({ data }) => {
      const intents = data.filter(x => !x.name.startsWith('__qna'))
      this.setState({ intents })
    })
  }

  fetchActions = () => {
    this.props.bp.axios.get(`/actions`, { baseURL: window.STUDIO_API_PATH }).then(({ data }) => {
      this.setState({
        actions: data
          .filter(action => !action.hidden)
          .map(x => {
            return { label: x.name, value: x.name, metadata: x.metadata }
          })
      })
    })
  }

  getSelectedIntent() {
    const intentName = this.state.selectedIntentOption && this.state.selectedIntentOption.value
    return intentName && this.state.intents.find(x => x.name === intentName)
  }

  getSelectedSlot(intent) {
    const slotName = this.state.selectedSlotOption && this.state.selectedSlotOption.value
    return intent && intent.slots.find(x => x.name === slotName)
  }

  isFormValid() {
    return (
      this.isTurnExpiryValid(this.state.turnExpiry) &&
      this.isRetryAttemptsValid(this.state.maxRetryAttempts) &&
      !this.state.errorField &&
      this.state.selectedIntentOption &&
      this.state.selectedSlotOption &&
      this.state.contentElement &&
      this.state.notFoundElement
    )
  }

  isTurnExpiryValid(turnExpiry) {
    return _.isNumber(turnExpiry) && (turnExpiry === -1 || turnExpiry > 0)
  }

  isRetryAttemptsValid(retryAttempts) {
    return _.isNumber(retryAttempts) && _.inRange(retryAttempts, 0, MAX_RETRIES + 1)
  }

  validateIntentExists = intentName => {
    if (!intentName) {
      return
    }

    const exists = this.state.intents.find(x => x.name === intentName)
    if (!exists) {
      this.setState({ error: 'Missing intent: This intent does not exist anymore!', errorField: 'intent' })
    }

    if (exists && this.state.errorField === 'intent') {
      this.clearError()
    }
  }

  clearError() {
    this.setState({ error: undefined, errorField: undefined })
  }

  validateSlotExists = (intentName, slotName) => {
    if (!intentName || !slotName) {
      return
    }

    const currentIntent = this.state.intents.find(x => x.name === intentName)
    if (!currentIntent || !currentIntent.slots.find(x => x.name === slotName)) {
      this.setState({ error: 'Missing slot: This slot does not exits anymore!' })
    }
  }

  handleContentChange = item => {
    this.setState({ contentElement: item.id })
  }

  handleSlotChange = selectedSlotOption => {
    this.validateSlotExists(this.state.selectedIntentOption.value, selectedSlotOption.value)
    this.setState({ selectedSlotOption })
  }

  handleIntentChange = selectedIntentOption => {
    this.validateIntentExists(selectedIntentOption.value)
    this.setState({ selectedIntentOption, selectedSlotOption: undefined })
  }

  handleNotFoundChange = item => {
    this.setState({ notFoundElement: item.id })
  }

  handleMaxRetryAttemptsChange = maxRetryAttempts => {
    if (!this.isRetryAttemptsValid(maxRetryAttempts)) {
      return this.setState({
        error: `Invalid settings: retry attempts should be between 0 and ${MAX_RETRIES}`,
        errorField: 'maxRetry'
      })
    }

    if (this.state.error && this.state.errorField === 'maxRetry') {
      this.clearError()
    }
    this.setState({ maxRetryAttempts })
  }

  handleTurnExpiryChange = turnExpiry => {
    if (!this.isTurnExpiryValid(turnExpiry)) {
      return this.setState({
        error: 'Invalid settings: turn expiry should be a number greater than 0 or -1',
        errorField: 'turnExp'
      })
    }

    if (this.state.error && this.state.errorField === 'turnExp') {
      this.clearError()
    }
    this.setState({ turnExpiry })
  }

  handleActionChange = selectedActionOption => {
    this.setState({ selectedActionOption })
  }

  getSlotOptionsForIntent(intent) {
    const slots = _.get(intent, 'slots', [])
    return slots.map(slot => {
      return { value: slot.name, label: slot.name }
    })
  }

  render() {
    const intent = this.getSelectedIntent()
    const intentsOptions = this.state.intents.map(intent => {
      return { value: intent.name, label: intent.name }
    })
    const slotOptions = this.getSlotOptionsForIntent(intent)

    return (
      <React.Fragment>
        <Row style={{ marginBottom: 10 }}>
          <Col md={5}>
            <Label>Choose an intent</Label>
            <Select
              id="intent"
              name="intent"
              isSearchable
              placeholder="Choose an intent or type to search"
              className={style.intentSelect}
              onChange={this.handleIntentChange}
              value={this.state.selectedIntentOption}
              options={intentsOptions}
            />
          </Col>
          <Col md={4}>
            <Label for="slot">Choose a slot to fill</Label>
            <Select
              id="slot"
              name="slot"
              isSearchable
              placeholder="Choose a slot or type to search"
              className={style.slotSelect}
              onChange={this.handleSlotChange}
              value={this.state.selectedSlotOption}
              options={slotOptions}
            />
          </Col>
          <Col md={3}>
            <Label for="turnExpiry">Expires after X turns</Label>
            &nbsp;
            <BotpressTooltip message="The information stored in the slot will be deleted after this number of turns. Set to -1 to never expire." />
            <NumericInput
              id="turnExpiry"
              name="turnExpiry"
              defaultValue={_.get(this.props, 'initialData.turnExpiry', DEFAULT_TURN_EXP)}
              selectAllOnFocus
              clampValueOnBlur
              majorStepSize={1}
              minorStepSize={1}
              min={-1}
              stepSize={1}
              onValueChange={this.handleTurnExpiryChange}
            />
          </Col>
        </Row>
        <Row>
          <Col md={9}>
            <Label for="contentPicker">Bot will ask...</Label>
            &nbsp;
            <BotpressTooltip message="The bot should ask a question specific about the slot to fill. (e.g. What is your email?)" />
            <ContentPickerWidget
              style={{ zIndex: 0 }}
              name="contentPicker"
              id="contentPicker"
              itemId={this.state.contentElement}
              onChange={this.handleContentChange}
              placeholder="Pick content"
            />
          </Col>
        </Row>
        <Row>
          <Col md="9">
            <Label>Message to send when user input is invalid</Label>
            &nbsp;
            <BotpressTooltip message="This message will appear to the user when the information he has given is invalid. (e.g. Your email is invalid)" />
            <ContentPickerWidget
              style={{ zIndex: 0 }}
              id="notFoundElement"
              itemId={this.state.notFoundElement}
              onChange={this.handleNotFoundChange}
              placeholder="Pick content to display when the slot is not found"
            />
          </Col>
          <Col md="3">
            <Label for="retryAttempts">Max retry attempts</Label>
            &nbsp;
            <BotpressTooltip message="This is the maximum number of times the bot will try to extract the slot. When the limit is reached, the bot will execute the 'On not found' transition." />
            <NumericInput
              id="retryAttempts"
              name="retryAttempts"
              defaultValue={_.get(this.props, 'initialData.retryAttempts', DEFAULT_RETRY_ATTEMPTS)}
              selectAllOnFocus
              clampValueOnBlur
              majorStepSize={1}
              minorStepSize={1}
              stepSize={1}
              min={0}
              max={MAX_RETRIES}
              onValueChange={this.handleMaxRetryAttemptsChange}
            />
          </Col>
        </Row>
        <Row>
          <Col md={12}>
            <Label for="validationCheck">
              <small>Custom Input Validation (optional)</small>
            </Label>
            &nbsp;
            <BotpressTooltip message="You can add custom validation for your slot with an action. It should assign a boolean value to the temp.valid variable." />
            <SelectActionDropdown
              className={style.actionSelect}
              value={this.state.selectedActionOption}
              options={this.state.actions}
              onChange={this.handleActionChange}
              isClearable={true}
            />
          </Col>
        </Row>
        <Row>
          <Col className={style.errorContainer} md={12}>
            {this.state.error && <Alert bsStyle="danger">{this.state.error}</Alert>}
          </Col>
        </Row>
      </React.Fragment>
    )
  }
}
