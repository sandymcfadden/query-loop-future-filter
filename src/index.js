import { __ } from "@wordpress/i18n";
import { addFilter } from "@wordpress/hooks";
import { createHigherOrderComponent } from "@wordpress/compose";
import { Fragment } from "@wordpress/element";
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody, SelectControl } from "@wordpress/components";

const withInspectorControls = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    if (props.name !== "core/query") {
      return <BlockEdit {...props} />;
    }

    const { attributes, setAttributes } = props;
    const { dateRange } = attributes.query;

    const dateRangeOptions = [
      { label: __("All Dates"), value: "all" },
      { label: __("Future Dates"), value: "future" },
      { label: __("Past Dates"), value: "past" },
    ];

    return (
      <Fragment>
        <BlockEdit {...props} />
        <InspectorControls>
          <PanelBody title={__("Date Range Settings")} initialOpen={true}>
            <SelectControl
              label={__("Select Date Range")}
              value={dateRange}
              options={dateRangeOptions}
              onChange={(value) => {
                setAttributes({
                  query: { ...attributes.query, dateRange: value },
                });
              }}
            />
          </PanelBody>
        </InspectorControls>
      </Fragment>
    );
  };
}, "withInspectorControls");

// Register our inspector controls
addFilter(
  "editor.BlockEdit",
  "sm-query-loop-relative-date-filter",
  withInspectorControls
);
