###########################################################################
# evaluation-script.R                                                     #
#                                                                         #
# Comparing Anomaly Detectors for Keystroke Biometrics                    #
# Evaluation Proceedure                                                   #
# R Script                                                                #
#                                                                         #
# by: Kevin Killourhy                                                     #
# date: May 19, 2009                                                      #
###########################################################################
sink("/dev/null");
library( stats );
library( MASS );

args <- commandArgs(trailingOnly = TRUE)
mahalanobisScore <- function( detection.model, YScore ) {
  p <- length( detection.model$mean );
  n <- nrow( YScore );

  if( ncol(YScore) != p ) stop("Training/test feature length mismatch ");

  scores <- mahalanobis( YScore,
                         detection.model$mean,
                         detection.model$covInv,
                         inverted=TRUE );
  return( scores );
}

detection.model.file <- paste("./components/biometrics/ajax/dmod", args[1], sep="/");
if( ! file.exists(detection.model.file) ) {
    stop( "Detection model file ", detection.model.file, " does not exist");
}
detection.model <- unserialize( charToRaw(
                           readChar( detection.model.file,
                                     file.info(detection.model.file)$size ) ) )

current.attempt.file <- paste("./components/biometrics/ajax/data", args[2], sep="/");
if( ! file.exists(current.attempt.file) ) {
    stop( "Current attempt data file ", current.attempt.file, " does not exist");
}
YScore <- read.csv( current.attempt.file,
                    nrows=2,
                    header=TRUE,
                    stringsAsFactors=FALSE );

YScore        <- as.matrix( YScore );
score         <- mahalanobisScore( detection.model, YScore );
deviation.avg <- score / length( detection.model );

sink();
write( deviation.avg , "" );
